<!DOCTYPE html>
<html>
<head>
    <title>Stress 테스트 페이지</title>
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
        <h1 class="display-4">Stress 테스트 페이지</h1>
        <p class="lead">Stress 테스트를 시작하거나 중지하려면 아래 버튼을 누르세요.</p>
        <p id="status" class="lead"></p>
        <div class="btn-group mt-4" role="group">
            <button onclick="startStress()" class="btn btn-danger">Stress 시작</button>
            <button onclick="stopStress()" class="btn btn-secondary">Stress 중지</button>
        </div>
    </div>

    <script>
        function startStress() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "stress_exec.php?start=1", true);
            xhr.send();
            document.getElementById("status").innerHTML = "Stress 테스트 중입니다.";
        }
        function stopStress() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "stress_exec.php?stop=1", true);
            xhr.send();
            document.getElementById("status").innerHTML = "Stress 테스트가 정지되었습니다.";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>