<?php
    session_start();
    require_once __DIR__ . '/lib/mysql.php';

    if(isset($_SESSION['id'])){
        die("<script> alert('Already Logined'); history.back(-1);</script>");
    }

    if(isset($_REQUEST['login-id']) && isset($_REQUEST['login-pw'])){
        $id = addslashes($_REQUEST['login-id']);
        $pw = hash('sha256', $_REQUEST['login-pw']);

        $query = "SELECT * FROM `users` WHERE `id` = '{$id}' AND `pw` = '{$pw}'";
        $res = mysqli_query($link, $query);

        $res = mysqli_fetch_array($res);
        
        if(count($res) >= 1){
            $_SESSION['id'] = $res['id'];
            $_SESSION['name'] = $res['name'];
            die("<script> alert('Success!'); location.href='/';</script>");
        }else{
            die("<script> alert('Fail..'); history.back(-1);</script>");
        }
    } else if(isset($_REQUEST['register-id']) && isset($_REQUEST['register-pw']) && isset($_REQUEST['register-name']) && isset($_REQUEST['register-re-pw'])) {
        $id = addslashes($_REQUEST['register-id']);
        $pw = hash('sha256', $_REQUEST['register-pw']);
        $repw = hash('sha256', $_REQUEST['register-re-pw']);
        $name = addslashes($_REQUEST['register-name']);

        if(strcmp($pw, $repw) != 0){
            die("<script> alert('Check pw!'); location.href='/login.php';</script>");
        }
        $query = "INSERT INTO `users` VALUES ('{$id}', '{$pw}', '{$name}')";
        mysqli_query($link, $query);
        
        die("<script> alert('Success!'); location.href='/login.php';</script>");
    } else {
?>

<?php require_once __DIR__ . '/lib/header.php'; ?>

<body>
    <div class="background"></div>
    <div class="background-overlay">
            <div class="line"></div>
            <p>온라인 인공지능 판결<br>집단지성 기반의 온라인 실시간 자동 재판 투표 서비스<br><span style="    font-family: 'Noto Sans KR Bold';">‘AI & Online Judge Service'</span></p>
    </div>
    <div class="right-panel">
        <div class="login">
            <div class="logo"></div>
            <div class="panel-title">로그인</div>
            <form method="post" action="/login.php">
                <input type="input" class="aoj-textbox" id="login-id" name="login-id" placeholder="ID">
                <input style="letter-spacing: .4px;" type="password" class="aoj-textbox" id="login-pw" name="login-pw" placeholder="PW">
                <input type="submit" class="aoj-active-button" value="로그인">
            </form>
            <div style="color: #c7c7c7; text-align: center;" ><h4>또는 <span style="color: #2293f1; cursor: hand;" class="goregister">회원가입</span></h4></div>
        </div>
        <div style="display: none;" class="register">
                <div class="logo"></div>
                <div class="panel-title">회원가입</div>
                <form method="post" action="/login.php">
                    <input type="input" class="aoj-textbox" id="register-name" name="register-name" placeholder="NAME">
                    <input type="input" class="aoj-textbox" id="register-id" name="register-id" placeholder="ID">
                    <input style="letter-spacing: .4px;" type="password" class="aoj-textbox" id="register-pw" name="register-pw" placeholder="PW">
                    <input style="letter-spacing: .4px;" type="password" class="aoj-textbox" id="register-re-pw" name="register-re-pw" placeholder="Retype-PW">
                    <input type="submit" class="aoj-active-button" value="회원가입">
                </form>
                <div style="color: #c7c7c7; text-align: center;"><h4>또는 <span style="color: #2293f1; cursor: hand;" class="gologin">로그인</span></h4></div>
            </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="/js/anime.js"></script>

<script>
    $('.goregister').click(function () { $('.register').css('display', 'block');$('.login').css('display', 'none'); });
    $('.gologin').click(function () { $('.login').css('display', 'block');$('.register').css('display', 'none'); });
</script>
</html>

<?php } ?>
