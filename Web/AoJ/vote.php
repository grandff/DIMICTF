<?php require_once __DIR__ . '/lib/mysql.php'; ?>

<?php
    if(isset($_POST['type']) && isset($_POST['idx'])){
        $type = intval($_POST['type']);
        $idx  = intval($_POST['idx']);

        if($type == 1){
            $query = "UPDATE `courtmakes` set defendant_point=defendant_point+1 where idx={$idx}";
        }else{
            $query = "UPDATE `courtmakes` set delator_point=delator_point+1 where idx={$idx}";
        }

        mysqli_query($link, $query);
    }
?>