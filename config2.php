<?php    
    session_start();
    require_once('class/user.class.php');
    echo "<pre>";
        var_dump($user);
    echo "</pre>";
    
    $dFim = date("Y-m-d");
    
?>