#!/bin/bash

# 변수 입력 받기
read -p "NHN Cloud Username: " USERNAME
read -p "NHN Cloud Tenant ID: " TENANT_ID
read -s -p "NHN Cloud Password: " PASSWORD
echo
read -p "Region (KR1/KR2): " REGION
read -p "Key Pair Name: " KEY_PAIR

# 변수값을 terraform.tfvars에 저장
cat <<EOF > terraform.tfvars
nhncloud_info = {
  user_name = "$USERNAME"
  tenant_id = "$TENANT_ID"
  auth_url  = "https://api-identity-infrastructure.nhncloudservice.com/v2.0"
}

passwd = "$PASSWORD"

region = "$REGION"

key_pair = "$KEY_PAIR"
EOF

# Terraform 실행
terraform init
terraform apply -auto-approve
