<?php session_start(); ?>
<?php require_once __DIR__ . '/lib/header.php'; ?>
<?php require_once __DIR__ . '/lib/mysql.php'; ?>
<?php require_once __DIR__ . '/lib/pusher.php'; ?>
<?php 
    if(isset($_REQUEST['courtmake-title']) && isset($_REQUEST['courtmake-content']) && isset($_REQUEST['courtmake-defendant']) && isset($_REQUEST['courtmake-delator']) && isset($_REQUEST['courtmake-deadline']) ){
        $title = addslashes($_REQUEST['courtmake-title']);
        $content = addslashes($_REQUEST['courtmake-content']);
        $defendant = addslashes($_REQUEST['courtmake-defendant']);
        $delator = addslashes($_REQUEST['courtmake-delator']);
        $deadline = addslashes($_REQUEST['courtmake-deadline']);

        $query = "INSERT INTO `courtmakes` VALUES (0,'{$title}','{$content}', '{$defendant}', '{$delator}', '{$deadline}', 0, 0)";
        
        mysqli_query($link, $query);

        $query = "SELECT * FROM `courtmakes` ORDER BY idx DESC LIMIT 0,1";

        $row = mysqli_fetch_assoc(mysqli_query($link, $query));
        $pusher->trigger('court-main', 'add', [
            'title' => htmlspecialchars($row['title']),
            'content' => htmlspecialchars($row['content']),
            'defendant' => htmlspecialchars($row['defendant']),
            'delator' => htmlspecialchars($row['delator']),
            'deadline' => htmlspecialchars($row['deadline']),
            'defendant_point' => htmlspecialchars($row['defendant_point']),
            'delator_point' => htmlspecialchars($row['delator_point']),
            'idx' => htmlspecialchars($row['idx']),
            'flag' => strtotime($row['deadline']) > time() ? '1' : '0'
        ]);

        die("<script> alert('Done!'); location.href='/'; </script>");
    } else {
?>

<body>
    <!-- <div class="background"></div> -->
    <div style="position: absolute; margin: 0 auto; left: 50%; margin-left: -25px; margin-top: 40px;width: 50px; height: 50px;"
        class="logo"></div>

    <div class="app">
        <div id="court-list" class="main">
            <div class="main-title">재판장</div>
            <div class="contents">
                <div id="court-make" style="background-color: #fff;">
                    <form method="post" action="/add-court.php" id="courtmake-form">
                        <input type="input" class="aoj-textbox" id="courtmake-title" name="courtmake-title" placeholder="사건 제목">
                        <textarea id="courtmake-content" class="aoj-textarea" placeholder="사건 내용" form="courtmake-form" name="courtmake-content"></textarea>
                        <input type="input" class="aoj-textbox" id="courtmake-defendant" name="courtmake-defendant" placeholder="피고인">
                        <input type="input" class="aoj-textbox" id="courtmake-delator" name="courtmake-delator" placeholder="고소인">
                        <input type="date" class="aoj-textbox" id="courtmake-deadline" name="courtmake-deadline" placeholder="마감 기간">
                        <input type="submit" class="aoj-active-button-rad" value="재판개설">
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="/js/anime.js"></script>
<script src="/js/pagetopage.js"></script>
<script>

</script>

</html>
<?php } ?>