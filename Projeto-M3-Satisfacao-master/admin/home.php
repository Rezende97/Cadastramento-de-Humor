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


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Administração</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

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
                <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>

                <li><a data-toggle="collapse" href="#sub_1">Listar humor <i class="fas fa-caret-square-down"></i></a></li>
                <div class="collapse" id="sub_1">
                    <li><a href="home.php?p=busca0"><i class="fas fa-caret-right"></i> Por usuário e por período</a></li>
                    <li><a href="home.php?p=busca1"><i class="fas fa-caret-right"></i> Apenas por período</a></li>
                </div>

                <li><a data-toggle="collapse" href="#sub_2">Contas de usuário <i class="fas fa-caret-square-down"></i></a></li>
                <div class="collapse" id="sub_2">
                    <li><a href="home.php?p=contas"><i class="fas fa-caret-right"></i> Alterar tipo de conta</a></li>
                    <li><a href="home.php?p=listar"><i class="fas fa-caret-right"></i> Listar contas</a></li>
                </div>
            </ul>
        </nav>
    </div>

    <div class="principal">
        <?php
        $valor = isset($_GET['p']) ? $_GET['p'] : "";

        switch ($valor) {

            case "busca0":
                require_once('pagina/busca0.php');
                break;

            case "busca1":
                require_once('pagina/busca1.php');
                break;

            case "contas":
                require_once('contas.php');
                break;

            default:
                require_once('pagina/comeco.php');
                break;
        }
        ?>
    </div>


    <footer>

    </footer>
</body>

</html>