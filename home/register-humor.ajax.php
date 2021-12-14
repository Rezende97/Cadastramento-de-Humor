<?php

require_once ('../config.php');

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['humor']) && !empty($_POST['humor'])) {

    #incluir classe humor apos atribuir pdo
    require_once('../class/humor.class.php');

    // Dados
    $id = $_SESSION['id'];
    $sent = $_POST['humor'];
    $comment = (isset($_POST['comment'])) ? $_POST['comment'] : null;  
    
    // Data
    $data = new DateTime();
    // dia atual
    $data_atual = $data->format('Y-m-d');
    // hora atual
    $hour = $data->format('H');

    // checar horário de registro do humor
    $periodo = $humor->checkHour($hour);

    // período 1 ou 2 então está dentro do horário
    if ($periodo == 1 || $periodo == 2) {

        // caso negação for verdadeiro, usuário já registrou humor
        if (!$humor->insertHumor($data_atual, $id, $periodo, $sent, $comment)) {
            echo json_encode(array('response' => 'already_register'));
        } else {
            echo json_encode(array('response' => 'register_success'));
        }
    } else {
        echo json_encode(array('response' => 'time_over'));        
    }
} else {
    echo json_encode(array('response' => 'humor_not_selected'));       
}

?>