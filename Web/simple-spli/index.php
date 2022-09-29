<?php 

//error_reporting(E_ALL); 
//ini_set("display_errors", 1); 


require 'lib.php'; 

if (isset($_GET['view-source'])){ 
    highlight_file(__FILE__); 
    exit; 
} 

$id = $_POST['id']; 
$pw = $_POST['pw']; 

//var_dump($conn); 

if (preg_match("/information|admin|or|\=| |\#|\'|_|where/i", $id . $pw)) 
    die("No Hack ~_~"); 

if (isset($id, $pw)) { 
    $query = "SELECT * FROM `users` WHERE `id` = trim('{$id}') AND `pw` = trim('{$pw}')"; 
    $result = mysqli_fetch_array(mysqli_query($conn, $query)); 

    if ($result['id'] === 'admin') 
        echo "<h1>{$flag}</h1>"; 

    if ($result['id']) { 
        $message = "{$result['id']}님 안녕하세요!"; 
    } else { 
        $message = "로그인에 실패하였습니다. 다시 시도해주세요."; 
    } 
} 



?> 
<!doctype html> 
<html lang="ko"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" 
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> 
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
    <title>인트라넷 로그인</title> 
    <style> 
        html, body { height:100%; overflow:hidden } 
        * { 
            margin: 0 auto; 
        } 
        .container { 
            width: 88%; 
            height: 100%; 
            align-content: center; 
            text-align: center; 
        } 
        .content { 
            margin: 0 auto; 
            padding-top: 0%; 
            padding-bottom: 0%; 
        } 
    </style> 
</head> 
<body> 
<div class="container"> 
    <div class="content"> 
        <form action="index.php" method="post"> 
            <h1>로그인하세요</h1> 
            <table> 
                <tr> 
                    <td> 
                        <input type="text" name="id" placeholder="ID" autocomplete="off"> 
                    </td> 
                    <td rowspan="2"> 
                        <input type="submit" value="로그인"> 
                    </td> 
                </tr> 
                <tr> 
                    <td> 
                        <input type="password" name="pw" placeholder="PW" autocomplete="off"> 
                    </td> 
                </tr> 
            </table> 
        </form> 
        <p>해당 페이지의 소스가 궁금하다면? <a href="?view-source">여기</a>를 클릭하세요!</p> 
        <p><?php echo $message; ?></p> 
    </div> 
</div> 
</body> 
</html> 