<?php require_once __DIR__ . '/lib/pusher.php'; ?>
<?php require_once __DIR__ . '/lib/mysql.php'; ?>

<?php
    $query = 'SELECT * FROM `courtmakes` ORDER BY idx DESC';
    $res = mysqli_query($link, $query);
    while($row = mysqli_fetch_assoc($res)){
        $pusher->trigger('court-main', 'init', [
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
    }
?>