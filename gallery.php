<?php
    $host_ip = "mydb";
    $host = gethostbyname($host_ip);
    $db   = 'galleryDB';
    $user = 'root'; // Your MySQL/MariaDB username
    $pass = 'Test123!'; // Your MySQL/MariaDB password
    $charset = 'utf8mb4';
    $public_ip = shell_exec('curl ifconfig.me');

   $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        // 데이터베이스 연결 성공
    } catch (PDOException $e) {
        // 데이터베이스 연결 오류 발생
        // 여기서 원하는 오류 메시지를 표시하거나 로그에 기록할 수 있습니다.
        die("데이터베이스 연결 오류: " . $e->getMessage());
        // 별도 페이지로 리디렉션하려면 header 함수를 사용할 수 있습니다.
        // header("Location: error_page.php");
        // exit; // 이후 코드를 실행하지 않음
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
         $pdo = new PDO($dsn, $user, $pass, $options);
         
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }    
    // Upload image to server and save details to database
    if(isset($_POST['upload'])){
        $name = $_FILES['file']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");

        // Check extension
        if( in_array($imageFileType,$extensions_arr) ){
            // Upload file
            if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                // Insert record
                $query = "INSERT INTO images(image_name, image_path) VALUES('".$name."','".$target_file."')";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                echo "Upload successfully.";

            }else {
                // 파일 업로드 실패
                echo "파일 업로드에 실패했습니다. 오류 코드: " . $_FILES['file']['error'];
            }
        } else {
            echo "지원하지 않는 파일 확장자입니다.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
    <div id="header"><a href="/"><img src="https://static.toastoven.net/toast/resources/img/logo_nhn_cloud_color.svg" /></a></div>

        <h1 class="text-center">Upload Image(<?php echo $_SERVER['SERVER_ADDR']?>)</h1>
        <form method="post" action="" enctype='multipart/form-data'>
            <div class="form-group">
                <input type='file' class="form-control-file" name='file' />
            </div>
            <button type='submit' class="btn btn-primary" name='upload'>Upload</button>
        </form>
        <h1 class="text-center mt-5">Image Gallery</h1>
        <div class="row">
            <?php
                $stmt = $pdo->prepare("SELECT image_path FROM images");
                $stmt->execute();
                while($row = $stmt->fetch()){
                    echo "<div class='col-md-4 mt-3'><img src='".$row['image_path']."' class='img-fluid'></div>";
                }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
