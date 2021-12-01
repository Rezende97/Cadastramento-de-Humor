<?php
    $db = new Database();
    
    $user = new User(
        $db->getConnection()
    );
    
    
    $dInicio = ($user->dataInicial($_SESSION['usuario']) !== "") ? $user->dataInicial($_SESSION['usuario']) : date("Y-m-d");
    
    $dFim = date("Y-m-d");
    
    $emails = $user->listaEmails();
?>