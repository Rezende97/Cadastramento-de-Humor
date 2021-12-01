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

$dInicio = $user->dataInicial($_SESSION['usuario']);

$dFim = date("Y-m-d");

$emails = $user->listaEmails();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de dados</title>
    <link rel="stylesheet" type="text/css" href="../css/general.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="../css/busca.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body class="text-center">
    <header>
        <div id="brand"><a href="index.php"><i class="fas fa-broadcast-tower"></i></a></div>
        <div id="painel"> 
            <span class="email"><small><?php echo $_SESSION['usuario']; ?></small></span>
            <span><a href="../auth/logout.php">Logout.</a></span>           
        </div>
    </header>
<main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <section id="list">
                        <div id="page-title"><h1>Listagem de dados</h1></div>                        
                        <div class="form-list">
                            <header class="form-header">
                                <span>Listar humor apenas por período</span>
                            </header>                        
                            <form action="../consulta/consulta_user.php" method="post">
                                <div class="container-data">
                                    <label>Data inicial:
                                        <input type="date" name="d_Inicio" min=<?php echo $dInicio?> max="<?php echo $dFim ?>" >
                                    </label>
                                    <label>Data final:
                                        <input type="date" name="d_Fim" min=<?php echo $dInicio?> max="<?php echo $dFim ?>" >
                                    </label>         
                                </div>
                                <div class="container-btn-submit"><button type="submit" class="btn btn-primary">Consultar</button></div>
                            </form>                         
                        </div>
                        <div class="float-left">
                            <p><a class="btn btn-info" href="index.php">Home</a></p>
                        </div>                        
                    </section>                
                </div>
            </div>
        </div>      
    </main>    
</body>

</html>