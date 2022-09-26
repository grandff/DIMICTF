<?php  
    if(isset($_GET['source'])){ 
        highlight_file(__FILE__); 
        exit; 
    } 

    $filter = ['system', 'exec', '`', '_', '\'', '"', 'file', 'open', 'read', 'eval', 'pass', 'include', 'require', '=', 'glob', 'dir', '/']; 
    $exec = $_GET['exec'];
 
    for($i = 0; $i < count($filter); $i++){  // exec로 입력한 값이 배열에 포함되는지 확인
        if(stristr($exec, $filter[$i])){ 
            die("Filtered"); 
        } 
    } 

    eval($exec); 

?> 

<a href="?source"> View Source </a> 
