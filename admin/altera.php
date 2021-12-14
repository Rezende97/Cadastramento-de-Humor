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

require_once('../../class/admin.class.php');

$usuario = $_POST['email'];
$nivel = $_POST['nivel'];

if($admin->alteraNivel($usuario, $nivel)){
    echo "Alteração efetuada com sucesso!";
} else{
    echo "Alteração não efetuada";
}

?>    