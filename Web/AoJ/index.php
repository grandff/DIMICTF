<?php session_start(); ?>
<?php 
    if(!isset($_SESSION['id'])){
        die("<script>location.href='/login.php'; </script>");
    }
?>

<?php require_once __DIR__ . '/lib/pusher.php'; ?>
<?php require_once __DIR__ . '/lib/mysql.php'; ?>
<?php require_once __DIR__ . '/lib/header.php'; ?>

<body>
    <!-- <div class="background"></div> -->
    <div style="position: absolute; margin: 0 auto; left: 50%; margin-left: -25px; margin-top: 40px;width: 50px; height: 50px;"
        class="logo"></div>

    <?php
        $query = 'SELECT * FROM `courtmakes` ORDER BY idx DESC';
        $res = mysqli_query($link, $query);
    ?>
    
    <div class="app">
        <div id="court-list" class="main">
            <div class="main-title">재판장</div>
            <div style="overflow: scroll; overflow-x: hidden;" class="contents court-main">
                <?php while($row = mysqli_fetch_assoc($res)){ ?>
                    <?php if(strtotime($row['deadline']) > time()) { ?>
                    <div onClick="toDetail(<?= $row['idx']; ?>, 1)" class="court court-1 idx-<?= $row['idx']; ?>">
                        <div class="court-title"><?= htmlspecialchars($row['title']); ?></div>
                        <div class="court-content">
                            <?= ($row['content']); ?>
                        </div>
                        <div class="court-defendant" style="display:none;"><?= htmlspecialchars($row['defendant']); ?> </div>
                        <div class="court-delator" style="display:none;"><?= htmlspecialchars($row['delator']); ?> </div>
                        <div class="court-deadline" style="display:none;"><?= htmlspecialchars($row['deadline']); ?> </div>
                        <div class="court-defendant-point" style="display:none;"><?= htmlspecialchars($row['defendant_point']); ?> </div>
                        <div class="court-delator-point" style="display:none;"><?= htmlspecialchars($row['delator_point']); ?> </div>
                    </div>
                <?php } else { ?>
                    <div onClick="toDetail(<?= $row['idx']; ?>, 0)" class="court court-1 idx-<?= $row['idx']; ?>">
                        <div class="court-title court-end"><?= htmlspecialchars($row['title']); ?></div>
                        <div class="court-content"> <?= ($row['content']); ?>
                        </div>
                        <div class="court-content-text" style="display:none;"><?= htmlspecialchars($row['content']); ?></div>
                        <div class="court-defendant" style="display:none;"><?= htmlspecialchars($row['defendant']); ?> </div>
                        <div class="court-delator" style="display:none;"><?= htmlspecialchars($row['delator']); ?> </div>
                        <div class="court-deadline" style="display:none;"><?= htmlspecialchars($row['deadline']); ?> </div>
                        <div class="court-defendant-point" style="display:none;"><?= htmlspecialchars($row['defendant_point']); ?> </div>
                        <div class="court-delator-point" style="display:none;"><?= htmlspecialchars($row['delator_point']); ?> </div>
                    </div>
                <?php }} ?>
            </div>

            <div onclick="window.open('/add-court.php', '_blank');" class="court-add">
                <div>+</div>
            </div>

        </div>
        
        <div id="court-detail" style="display: none;" class="main">
            <div class="main-title">
                <div onClick="pagestatus == 'court-detail' ? toList() : closeCommunity()" class="court-list-back"></div>
                    <span class="court-detail-title">asdf</span>
            </div>
            <div class="contents court-contents-court">
                <div class="court-detail-content">
                asdf
                </div>
                <div class="court-table">
                    <div class="court-column court-detail-defendant">피고인: <b class="court-detail-defendant-text">qwer </b></div>
                    <div class="court-column court-detail-deadline"><?= date("Y-m-d"); ?> ~ <span class="court-detail-deadline-text"> 2020.2.2 </span></div>
                    <div class="court-column court-detail-delator">고소인: <b class="court-detail-delator-text">asdf</b></div>
                    <div class="court-column court-detail-count">투표인원: <b class="court-detail-count-text">10명</b></div>
                </div>
                <input onClick="openCommunity()" type="button" style="width: 300px; height: 150px;"
                    class="aoj-active-button" value="참관하기">
            </div>

            <div id="court-community" style="display: none; background-color: #fff; opacity: 0;"
                class="contents court-contents-community">
                <div class="court-community-left">
                    <div class="courtor court-defendant">
                        <div class="court-mini-title">피고인: <b class="court-detail-defendant-text">윤석찬</b></div>
                        <div class="court-defendant-content">
                            
                        </div>
                        <input type="input" style="height: 60px; margin-bottom: 0;" class="aoj-textbox chatbox-defendant" id="postchat"
                        placeholder="피고인 의견남기기.." onkeydown="defendant(this)">
                    </div>
                    <div class="courtor court-delator">
                        <div class="court-mini-title">고소인: <b class="court-detail-delator-text">OOO</b></div>
                        <div class="court-delator-content">
                        
                        </div>
                        <input type="input" style="height: 60px; margin-bottom: 0;" class="aoj-textbox" id="postchat"
                        placeholder="고소인 의견남기기.." onkeydown="delator(this)">
                    </div>
                </div>
                <div class="court-community-right">
                    <div class="court-mini-title">커뮤니티</div>
                    <div class="court-community-chat">
                        <div class="court-chat court-chat-1"></div>
                       
                    </div>
                    <input onclick="vote(1)" type="button" class="aoj-vote-button-defendant" value="피고인에 투표">
                    <input onclick="vote(2)" type="button" class="aoj-vote-button-defendant" value="고소인에 투표">
                    <input type="input" style="height: 60px; margin-bottom: 0;" class="aoj-textbox" id="postchat"
                        placeholder="의견남기기.." onkeydown="allchat(this)">
                </div>
            </div>
        </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="/js/anime.js"></script>
<script src="/js/init.js"></script>
<script src="/js/pagetopage.js"></script>
<script src="/js/submit.js"></script>
<script>

</script>

</html>