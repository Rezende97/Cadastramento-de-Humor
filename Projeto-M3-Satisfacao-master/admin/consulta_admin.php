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

$user = new User($db->getConnection());

// parâmetro order não foi passado pelo get
if(!isset($_GET['order'])) {
    die('Falha, parâmetro de ordenação não identificado.');
}
// data
$data = new DateTime();
$day = $data->format('d');

// form data
$dInicio = $_POST['d_Inicio'];
$dFim = $_POST['d_Fim'];

if($dFim < $dInicio){
    ?>
        <script>
            alert("A data final não pode ser menor que a data inicial");
            window.location.href = "busca.php";
        </script>
    <?php
}


if($_GET['order'] == 'user') {
    $email = $_POST['email'];
    $list = $user->listHumorAdmin($dInicio, $dFim, $email);
    $title = 'Listagem por usuário';
} else if($_GET['order'] == 'date') {
    $list = $user->listHumor($dInicio, $dFim);
    $title = 'Listagem por período';
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de dados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="../css/consulta.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="text-center">
    <header>
        <div id="brand"><a href="home.php"><i class="fas fa-broadcast-tower"></i></a></div>
        <div id="painel">
            <span class="email"><small><?php echo $_SESSION['usuario']; ?></small></span>
            <span><a href="../auth/logout.php">Logout.</a></span>
        </div>
    </header>

    <div class="painel_lateral">
        <nav>
            <ul>
                <div>
                    <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
                </div>
                <li><a data-toggle="collapse" role="button" href="#sub_1">Listar humor <i class="fas fa-caret-square-down"></i> </a></li>
                <div>
                    <div class="collapse multi-collapse" id="sub_1">
                        <li><a href="home.php?p=busca0"><i class="fas fa-caret-right"></i> Por usuário e por período</a></li>
                        <li><a href="home.php?p=busca1"><i class="fas fa-caret-right"></i> Apenas por período</a></li>
                    </div>
                </div>
                <div>
                    <li><a href="home.php?p=classifica">Classificar usuários</a></li>
                </div>
            </ul>
        </nav>
    </div>
    <main>
        <div>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
              </ol>
            </nav>            
        </div>
        <section id="humor-list">
            <div>
                <table style="width:100%" align="center">
                    <tr>
                        <th style="width: 14%;">Usuário</th>
                        <th style="width: 10%;">Data</th>
                        <th style="width: 10%;">Humor Inicial</th>
                        <th style="width: 27%;">Commentário</th>
                        <th style="width: 8%;">Humor Final</th>
                        <th style="width: 27%;">Commentário</th>
                    </tr> 
                     
                    <?php for($i=0; $i < sizeof($list) ; $i++) {
                        $user = $list[$i]['email'];
                        $year = $list[$i]['YEAR(humor.data)'];
                        $month = $list[$i]['MONTH(humor.data)'];
                        $day = $list[$i]['DAY(humor.data)'];
                        $humor_initial = $list[$i]['humor_initial'];
                        $humor_final = $list[$i]['humor_final'];
                        $first_comment = $list[$i]['comment_initial'];
                        $last_comment = $list[$i]['comment_final'];
                    ?>
                        <tr>
                            <td><?= $user; ?></td>
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
        </section>
    </main>
    </body>
</html>