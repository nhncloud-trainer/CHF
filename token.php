<?php

$TENANT_ID = $_POST['TENANT_ID'];
$USERNAME = $_POST['USERNAME'];
$PASSWORD = $_POST['PASSWORD'];
$CONTAINER_NAME = $_POST['CONTAINER_NAME'];
$STORAGE_URL = $_POST['STORAGE_URL'];
$STORAGE_URL = $STORAGE_URL.'/v1/AUTH_'.$TENANT_ID;

function get_token($auth_url, $tenant_id, $username, $password) {
  $url = "$auth_url/tokens";
  $req_body = array(
    'auth' => array(
      'tenantId' => $tenant_id,
      'passwordCredentials' => array(
        'username' => $username,
        'password' => $password
      )
    )
  );  // 요청 본문 생성
  $req_header = array(
    'Content-Type: application/json'
  );  // 요청 헤더 생성

  $curl  = curl_init($url); // curl 초기화
  curl_setopt_array($curl, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => $req_header,
    CURLOPT_POSTFIELDS => json_encode($req_body)
  )); // 파라미터 설정
  $response = curl_exec($curl); // API 호출
  $response_data = json_decode($response);
  $token_id = $response_data->access->token->id;
  curl_close($curl);

  return $token_id;
}
class ObjectService {
    private $storage_url;
    private $token_id;
  
    function __construct($storage_url,  $token_id) {
      $this->storage_url = $storage_url;
      $this->token_id = $token_id;
    }
  
    function get_url($container, $object) {
      return $this->storage_url . '/' . $container . '/' . $object;
    }
  
    function get_request_header() {
      return array(
        'X-Auth-Token: ' . $this->token_id
      );
    }
  
    function upload($container, $object, $filename) {
      $req_url = $this->get_url($container, $object);
      $req_header = $this->get_request_header();
      $fd = fopen($filename, 'r');
      $curl = curl_init($req_url);
      curl_setopt_array($curl, array(
          CURLOPT_PUT => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_INFILE => $fd,
          CURLOPT_HTTPHEADER => $req_header
      ));
      $response = curl_exec($curl);
      $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      fclose($fd);
  
      if ($http_code == 201) {
          echo '업로드 성공: ' . $object . "<br>";
          return true;
      } else {
          echo '업로드 실패: ' . $object . ' (오류 코드: ' . $http_code . ")<br>";
          return false;
      }
  }
  }

$AUTH_URL = 'https://api-identity-infrastructure.nhncloudservice.com/v2.0';
$token_id = get_token($AUTH_URL, $TENANT_ID, $USERNAME, $PASSWORD);
$OBJ_PATH = '/var/www/html/upload';
$object = new ObjectService($STORAGE_URL, $token_id);
$files = scandir($OBJ_PATH);

// 디렉토리 내의 파일 목록을 가져오기
$files = scandir($OBJ_PATH);

// 디렉토리 내의 각 파일에 대한 루프
foreach ($files as $file) {
  if ($file !== '.' && $file !== '..') {
      $filePath = $OBJ_PATH . '/' . $file;
      if (file_exists($filePath)) {
          $fileContents = file_get_contents($filePath);
          $fileContents = iconv('EUC-KR', 'UTF-8', $fileContents);
          
          // 업로드 시도
          $uploadResult = $object->upload($CONTAINER_NAME, $file, $filePath);
          
          if ($uploadResult) {
              echo $file . " 파일이 성공적으로 업로드되었습니다.<br>";
          } else {
              echo $file . " 파일 업로드에 실패했습니다.<br>";
          }
      } else {
          echo "파일을 찾을 수 없습니다: " . $file . "<br>";
      }
      echo "<br>";
  }
}
?>
