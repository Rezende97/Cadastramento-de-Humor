<?php
if (!isset($_SESSION)) {
    session_start();
}

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
    header('location: ../index.html');
}

require_once('../model/db.php');
require_once('../class/user.class.php');

$db = new Database();

$user = new User(
    $db->getConnection()
);


$dInicio = $user->dataInicial($_POST['email']);

echo $dInicio;


?>