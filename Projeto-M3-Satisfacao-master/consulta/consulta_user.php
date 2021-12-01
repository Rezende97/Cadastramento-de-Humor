<?php

require_once ('../config.php');

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
    header('location: ../index.html');
}

require_once ('../model/db.php');

$db = new Database();

$pdo = $db->getConnection();

require_once ('../class/user.class.php');

// importa arquivo de class humor, após instancia da classe database
require_once ('../class/humor.class.php');

$humor_obj = new Humor($db->getConnection());
$user = new User($db->getConnection());

// dia atual
$data = new DateTime();
$day = $data->format('d');

$dInicio = $_POST['d_Inicio'];
$dFim = $_POST['d_Fim'];

if($dFim < $dInicio){
    ?>
        <script>
            alert("A data final não pode ser menor que a data inicial");
            window.location.href = "../home/busca.php";
        </script>
    <?php
}

$email = $_SESSION['email'];



$list = $humor_obj->listHumorByUser($dInicio, $dFim, $email);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de dados</title>

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../css/consulta.css">

</head>

<body class="text-center">
    <header>
        <div id="brand"><a href="../home/index.php"><i class="fas fa-broadcast-tower"></i></a></div>
        <div id="painel"> 
            <span class="email"><small><?php echo $_SESSION['usuario']; ?></small></span>
            <span><a href="../auth/logout.php">Logout.</a></span>           
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row" id="center">
                <div class="col-sm-12">
                    <section id="humor-list">
                        <h1>Listagem de dados</h1>
                        <div>
                            <table style="width:100%" align="center">
                                <tr>
                                    <th>Data</th>
                                    <th>Humor Inicial</th>
                                    <th>Commentários</th>
                                    <th>Humor Final</th>
                                    <th>Commentários</th>
                                </tr> 
                                 
                                <?php for($i=0; $i < sizeof($list) ; $i++) {
                                    $year = $list[$i]['YEAR(humor.data)'];
                                    $month = $list[$i]['MONTH(humor.data)'];
                                    $day = $list[$i]['DAY(humor.data)'];
                                    $humor_initial = $list[$i]['humor_initial'];
                                    $humor_final = $list[$i]['humor_final'];
                                    $first_comment = $list[$i]['comment_initial'];
                                    $last_comment = $list[$i]['comment_final'];
                                ?>
                                    <tr>
                                        <td><?= $day . "/" . $month . "/" . $year; ?></td>
                                        <td> <?= (isset($humor_initial)) ? $humor->formatHumor($humor_initial) : null; ?></td>
                                        <td> <?= (isset($first_comment)) ? $first_comment : null; ?></td>
                                        <td> <?= (isset($humor_final)) ? $humor->formatHumor($humor_final) : null; ?></td>
                                        <td> <?= (isset($last_comment)) ? $last_comment : null; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>                              
                        </div>
                        <div class="float-left">
                            <div class="btn-group" role="group" aria-label="Basic example" id="button">
                                <a href="../home/busca.php"><button class="btn btn-info">Voltar</button></a>
                                <a href="../home/index.php"><button class="btn btn-info">Seguir Home</button></a>
                            </div>                             
                        </div>                                                                    
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>