<?php

require_once 'lib.php';

session_start();
$session = md5(session_id());
$uploaddir = __DIR__ . "/~uploads/{$session}/";

createDirectory(__DIR__ . "/~uploads/");
createDirectory($uploaddir);

//print_r($_FILES['file']);
$file = $_FILES['file'];
$uploadfile = $uploaddir . $file['name'];

// sanity check
$extension = explode('.', $file['name'])[1];
if (!in_array($extension, Array("jpg", "gif", "png")))
{
    $message = "<script>alert('jpg, gif, png 확장자만 업로드할 수 있습니다.'); history.back(); </script>";
    die($message);
}

// the real sanity check
$real_extension = array_pop(explode('.', $file['name']));
if (preg_match("/php/i", $file['name']))
{
    $message = "<script>alert('파일 이름에 php가 들어가면 안됩니다.'); history.back(); </script>";
    die($message);
}

if ($file['size'] > 4096)
{
    $message = "<script>alert('최대 4mb까지 업로드할 수 있습니다.'); history.back(); </script>";
    die($message);
}

if (move_uploaded_file($file['tmp_name'], $uploadfile))
{
    $message = "<script>alert('성공적으로 파일이 업로드되었습니다.'); location.href = '/'; </script>";
    echo $message;
}


else
{
    $message = "<script>alert('업로드 에러'); history.back(); </script>";
    echo $message;
}
