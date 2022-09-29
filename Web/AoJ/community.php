<?php require_once __DIR__ . '/lib/pusher.php'; ?>
<?php require_once __DIR__ . '/lib/mysql.php'; ?>
<?php session_start(); ?>

<?php
    // type == 1 : defendant
    // type == 2 : delator
    // type == 3 : all
    if(isset($_POST['type']) && isset($_POST['comment']) && isset($_POST['idx']) ){
        $type = intval($_POST['type']);
        $comment = addslashes($_POST['comment']);
        $idx = intval($_POST['idx']);
        if($type == 1){
            $query = "INSERT INTO `defendant_community` VALUES (0, {$idx}, '{$comment}')";
            mysqli_query($link, $query);
            $pusher->trigger('defendant-' . $idx, 'add', [
                'message' => htmlspecialchars($comment)
            ]);
        }else if($type == 2){
            $query = "INSERT INTO `delator_community` VALUES (0, {$idx}, '{$comment}')";
            mysqli_query($link, $query);
            $pusher->trigger('delator-'. $idx, 'add', [
                'message' => htmlspecialchars($comment)
            ]);
        }else if($type == 3){
            $id = $_SESSION['id'];
            $query = "SELECT name FROM `users` where id='{$id}'";   
            $name = mysqli_fetch_assoc(mysqli_query($link, $query))['name'];
            $cmd = $name . ': ' . $comment;
            if(!strcmp($name, $_SESSION['name'])){
                $query = "INSERT INTO `all_community` VALUES (0, {$idx}, '{$cmd}')";
                mysqli_query($link, $query);
                
                $pusher->trigger('allchat-'. $idx, 'add', [
                    'message' =>  htmlspecialchars($cmd)
                ]);
            }else{
                echo htmlspecialchars($cmd);
            }
        }

    }
?>