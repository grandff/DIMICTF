<?php require_once __DIR__ . '/lib/pusher.php'; ?>
<?php require_once __DIR__ . '/lib/mysql.php'; ?>


<?php
    if(isset($_POST['idx'])){
        $idx = intval($_POST['idx']);

        $db = ['defendant', 'delator', 'all'];

        for($i = 0; $i < count($db); $i++){
            $query = "SELECT comment FROM `{$db[$i]}_community` where id={$idx}";
            echo $query;
            $res = mysqli_query($link, $query);
            while($row = mysqli_fetch_assoc($res)){
                if($db[$i] == "all"){
                    $pusher->trigger('allchat-'.$idx, 'add', [
                        'message' => htmlspecialchars($row['comment'])
                    ]);
                }else{
                    $pusher->trigger($db[$i].'-'.$idx, 'add', [
                        'message' => htmlspecialchars($row['comment'])
                    ]);
                }
                
            }
        }
        
    }
?>