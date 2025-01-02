<!DOCTYPE html>
<html>
<head>
    <title>Object Storage 연결 정보</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <div class="container">
            <a href="/">
                <img src="https://static.toastoven.net/toast/resources/img/logo_nhn_cloud_color.svg" class="img-fluid" alt="Logo" />
            </a>
        </div>
    </header>

    <div class="container mt-5">
        <h1 class="display-4 text-center">Object Storage 연결 정보</h1>
        <h6 class="text-center text-muted">API 엔드포인트 설정 정보를 Console에서 확인 후 기재해주세요</h6>
        <h6 class="text-center text-muted hidden-text">Object storage 엔드포인트 정보 : https://kr2-api-object-storage.nhncloudservice.com</h6>        <form action="token.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="STORAGE_URL" class="form-label text-start">STORAGE_URL:</label>
                <input type="text" id="STORAGE_URL" name="STORAGE_URL" class="form-control">
            </div>
            <div class="mb-3">
                <label for="TENANT_ID" class="form-label text-start">TENANT_ID:</label>
                <input type="text" id="TENANT_ID" name="TENANT_ID" class="form-control">
            </div>
            <div class="mb-3">
                <label for="USERNAME" class="form-label text-start">NHN Cloud ID:</label>
                <input type="text" id="USERNAME" name="USERNAME" class="form-control">
            </div>
            <div class="mb-3">
                <label for="PASSWORD" class="form-label text-start">Password:</label>
                <input type="password" id="PASSWORD" name="PASSWORD" class="form-control">
            </div>
            <div class="mb-3">
                <label for="CONTAINER_NAME" class="form-label text-start">CONTAINER_NAME:</label>
                <input type="text" id="CONTAINER_NAME" name="CONTAINER_NAME" class="form-control">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">데이터 업로드</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>