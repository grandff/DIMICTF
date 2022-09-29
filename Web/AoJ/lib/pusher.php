<?php require_once __DIR__ . '/../vendor/autoload.php'; ?>
<?php
    $options = array(
        'cluster' => 'ap3',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '1606ea21cf9654d0a228',
        'a2f5042239f6316a72ca',
        '784738',
        $options
    );
?>