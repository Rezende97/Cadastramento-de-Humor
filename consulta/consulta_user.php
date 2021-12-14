<?php

require_once('../config.php');

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
    header('location: ../index.html');
}

$dInicio = $_POST['d_Inicio'];
$dFim = $_POST['d_Fim'];
$email = $_SESSION['email'];

if ($dFim < $dInicio) {
?>
    <script>
        alert("A data final não pode ser menor que a data inicial");
        window.location.href = "../home/busca.php";
    </script>
<?php
}

// Dados
$data = new DateTime();
$day = $data->format('d');


require_once('../class/humor.class.php');

$list = $humor->listHumorByUser($dInicio, $dFim, $email);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de dados</title>

    <link rel="stylesheet" type="text/css" href="http://localhost/M/css/general.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../css/consulta.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- Dependências para Exportação para Excel e CSV -->
    <script type="text/javascript" src="../lib/tableExport/libs/FileSaver/FileSaver.min.js"></script>
    <script type="text/javascript" src="../lib/tableExport/tableExport.min.js"></script>
    <script type="text/javascript" src="../lib/tableExport/libs/js-xlsx/xlsx.core.min.js"></script>
    <script type="text/javascript" src="../lib/tableExport/libs/jsPDF/jspdf.umd.min.js"></script>


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
                    <div class="float-left">
                        <div class="btn-group" role="group" aria-label="Basic example" id="button">
                            <a href="../home/busca.php"><button class="btn btn-info">Voltar</button></a>
                            <a href="../home/index.php"><button class="btn btn-info">Página inicial</button></a>

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                                    Salvar listagem como
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="salvarPdf.php?dInicio=<?php echo $dInicio ?>&dFim=<?php echo $dFim ?>" target="_blank">PDF</a></li>
                                    <li><a class="dropdown-item" id="btnExcel" href="#">Excel</a></li>
                                    <li><a class="dropdown-item" id="btnCsv" href="#">CSV</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <section id="humor-list">
                        <h1>Listagem de dados</h1>
                        <div id="humor-table">
                            <table style="width:100%" align="center">
                                <tr>
                                    <th>Data</th>
                                    <th>Humor Inicial</th>
                                    <th>Commentários</th>
                                    <th>Humor Final</th>
                                    <th>Commentários</th>
                                </tr>

                                <?php for ($i = 0; $i < sizeof($list); $i++) {
                                    $year = $list[$i]['year'];
                                    $month = $list[$i]['month'];
                                    $day = $list[$i]['day'];
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
                    </section>
                    <script>
                        $("#btnExcel").click(function() {
                            $("#humor-table").tableExport({
                                type: 'xlsx',
                                fileName: 'Listagem'

                            });
                        });

                        $("#btnCsv").click(function() {
                            $("#humor-table").tableExport({
                                type: 'csv',
                                fileName: 'Listagem'
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </main>
</body>

</html>