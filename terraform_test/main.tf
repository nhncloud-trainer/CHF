terraform {
  required_version = ">= 1.0.0"
  required_providers {
    nhncloud = {
      source  = "nhn-cloud/nhncloud"
      version = "1.0.2"
    }
  }
}

provider "nhncloud" {
  user_name = var.nhncloud_info["user_name"]
  tenant_id = var.nhncloud_info["tenant_id"]
  password  = var.passwd
  auth_url  = var.nhncloud_info["auth_url"]
  region    = var.region
}

variable "nhncloud_info" {
  type = map(string)
}

variable "passwd" {
  type      = string
  sensitive = true
}

variable "region" {
  type = string
}

variable "key_pair" {
  type = string
}

# VPC 생성
resource "nhncloud_networking_vpc_v2" "terraform_vpc" {
  name   = "terraform_vpc"
  cidrv4 = "10.0.0.0/16"
}

# 서브넷 생성
resource "nhncloud_networking_vpcsubnet_v2" "public_subnet" {
  name   = "terraform_pub_subnet"
  vpc_id = nhncloud_networking_vpc_v2.terraform_vpc.id
  cidr   = "10.0.1.0/24"
}

# 네트워크 포트 생성
resource "nhncloud_networking_port_v2" "port_1" {
  name           = "tf_port_1"
  network_id     = nhncloud_networking_vpc_v2.terraform_vpc.id
  admin_state_up = "true"
  fixed_ip {
    subnet_id = nhncloud_networking_vpcsubnet_v2.public_subnet.id
  }
}

# 웹 서버 인스턴스 생성
resource "nhncloud_compute_instance_v2" "web_server" {
  name            = "web_server"
  key_pair        = var.key_pair
  flavor_id       = data.nhncloud_compute_flavor_v2.m2c1m2.id
  security_groups = ["default"]

  network {
    port = nhncloud_networking_port_v2.port_1.id
  }

  block_device {
    uuid                  = data.nhncloud_images_image_v2.myweb.id
    source_type           = "image"
    destination_type      = "volume"
    boot_index            = 0
    volume_size           = 20
    delete_on_termination = true
  }
}

# 인스턴스 타입 조회
data "nhncloud_compute_flavor_v2" "m2c1m2" {
  name = "m2.c1m2"
}

# 사용할 이미지 조회
data "nhncloud_images_image_v2" "myweb" {
  name       = "web-img"
  visibility = "private"
}
