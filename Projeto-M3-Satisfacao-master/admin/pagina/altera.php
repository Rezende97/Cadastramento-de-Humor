<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
        header('location: ../index.html');
    } else {
        if ($_SESSION['nivel'] < 1) {
            header('location: ../home/index.php');
        }
    }


    require_once('../../model/db.php');
    require_once('../../class/user.class.php');
    require_once('config.php');

    $usuario = $_POST['email'];
    $nivel = $_POST['nivel'];

    if($user->alteraNivel($usuario, $nivel)){
        echo "Alteração efetuada com sucesso!";
    } else{
        echo "Alteração não efetuada";
    }