<?php
    session_start();
    unset($_SESSION['usuario']);
    header('refresh: 1, ../index.html');
?>