<?php
if (!isset($_SESSION)) {
    session_start();
}

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
    header('location: ../index.html');
}

require_once('../class/humor.class.php');
require_once('../class/admin.class.php');

$dInicio = $humor->dataInicial($_SESSION['usuario'])[0]['data'];

$dFim = date("Y-m-d");

$emails = $admin->listaEmails();

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
                                        <input type="date" class="verificaData" name="d_Inicio" id="d_Inicio" min=<?php echo $dInicio?> max="<?php echo $dFim ?>" >
                                    </label>
                                    <label>Data final:
                                        <input type="date" class="verificaData" name="d_Fim" id="d_Fim" min=<?php echo $dInicio?> max="<?php echo $dFim ?>" >
                                    </label>         
                                </div>
                                <div class="container-btn-submit"><button type="submit" id="enviar" class="btn btn-primary">Consultar</button></div>
                                <div id="mensagem" style="font-size: small; color: red"></div>
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

    <script>
       var botao = document.getElementById('enviar');
       botao.disabled = true;
        Array.from(document.getElementsByClassName('verificaData')).forEach(function(data){
            data.addEventListener('change', check);
        })

        function check(e){
            
            var inicial = document.getElementById('d_Inicio').value;
            var final = document.getElementById('d_Fim').value;
            if (inicial != "" && final != ""){
                if(final < inicial){
                   botao.disabled = true;
                   document.getElementById("mensagem").innerHTML = "<label> A data final não pode ser menor que a inicial</label>";
                } else{
                    botao.disabled = false;
                    document.getElementById("mensagem").innerHTML = "";
                }
            }
        }
        
    </script>

</body>

</html>