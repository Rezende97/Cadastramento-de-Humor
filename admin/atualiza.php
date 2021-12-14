<?php

if (!isset($_SESSION)) {
    session_start();
}

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
    header('location: ../index.html');
}

require_once('../class/humor.class.php');

$dInicio = $humor->dataInicial($_POST['email']);

echo $dInicio[0]['data'];


?>