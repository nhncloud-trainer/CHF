<!DOCTYPE html>
<html>
<head>
    <title>웹 서버 IP 주소 확인</title>
    <!-- Link to Bootstrap CSS -->
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

    <div class="container mt-5 text-center">
        <h1 class="display-4">현재 웹 서버의 IP 주소</h1>
        <p class="lead"><?php echo $_SERVER['SERVER_ADDR']; ?></p>
        <div class="btn-group mt-4" role="group">
            <button class="btn btn-secondary" onclick="location.href='gallery.php'">Gallery Page</button>
            <button class="btn btn-primary" onclick="location.href='stress.php'">Stress Test</button>
            <button class="btn btn-secondary" onclick="location.href='obj.php'">Object Upload</button>
        </div>
    </div>

    <!-- Link to Bootstrap JavaScript (Optional: Only required if you use Bootstrap JavaScript components) -->
    <!-- Add this script tag at the end of the body section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>