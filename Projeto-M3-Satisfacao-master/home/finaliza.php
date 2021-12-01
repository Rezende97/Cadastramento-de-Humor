<?php

require_once ('../config.php');

if (isset($_POST['humor']) && !empty($_POST['humor'])) {

    #incluir classe database
    require_once('../model/db.php');

    #instanciar e atribuir pdo antes de instanciar classe humor
    $database = new Database();
    $pdo = $database->getConnection();

    #incluir classe humor apos atribuir pdo
    require_once('../class/humor.class.php');

    // Dados
    $id = $_SESSION['id'];
    $sent = $_POST['humor'];
    $comment = (isset($_POST['comment'])) ? $_POST['comment'] : null; 
    
    // Data
    $data = new DateTime();

    // dia atual
    $day = $data->format('d');

    // hora atual
    $hour = $data->format('H');

    $db = new Database;
    $pdo = $db->getConnection();

    // checar horário de registro do humor
    $periodo = $humor->checkHour($hour);

    // se periodo for = 1 ou 2, então está no horário de envio do humor
    if ($periodo == 1 || $periodo == 2) {

        // se der falha no registro do humor, entao usuário já registrou humor hoje
        if (!$humor->insertHumor($day, $id, $periodo, $sent, $comment)) {
?>
            <script>
                alert("falha, humor já foi registrado!");
                window.location.href = "../home/index.php";
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert("fora do horário de registro do humor.");
            window.location.href = "index.php";
        </script>
    <?php
    }

    $humor = new Humor($pdo);
} else {
    ?>
    <script>
        alert("falha! Humor não selecionado.");
        window.location.href = "index.php";
    </script>

<?php
}

date_default_timezone_set('America/Sao_Paulo');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Humor selecionado</title>
</head>

<body style="text-align: center;">

    <header>
            <div id="brand"><a href="index.php"><i class="fas fa-broadcast-tower"></i></a></div>
            <div id="painel"> 
                <span class="email"><small><?php echo $_SESSION['usuario']; ?></small></span>
                <span><a href="../auth/logout.php">Logout.</a></span>			
            </div>
        </header>
    <br>
    <p style="color: green; margin-top: 100px;">Humor inicial adicionado com sucesso
        <?php
        echo "às " . date('H:i') . "!";
        ?>
    </p>

    <br>
    <p style="color: orange;">O humor final deve ser escolhido no final do expediente.</p>
    <p>
        <a href="index.php" class="btn btn-primary">Voltar</a>
    </p>

</body>

</html>