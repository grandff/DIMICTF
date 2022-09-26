<?php session_start(); ?>
<?php require_once 'lib.php'; ?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload service</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Upload your own file. it's secure and fast.</h1>
        <div class="row">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="form-group">
                <div class="col-md-1">
                    <h4>file</h4>
                </div>
                <div class="col-md-5">
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="col-md-1">
                    <input type="submit" value="submit" class="btn btn-info">   <!-- submit 할 경우 file을 upload.php으로 전송함 -->
                </div>
            </form>
        </div>
        <hr>

        <h3>Your uploaded files</h3>
        <?php

        $session = md5(session_id());
        $uploaddir = __DIR__ . "/~uploads/{$session}/"; // 업로드 경로 설정
        $files = listDirectory($uploaddir);

        foreach ($files as $file)
        {
            if ($file !== '.' && $file !== '..')
            {
                $file = xss($file); // html tag를 특수문자로 변환
                echo "<p><a href='/~uploads/{$session}/$file'>$file</a></p>";
            }

        }

        ?>

    </div>
</body>
</html>
