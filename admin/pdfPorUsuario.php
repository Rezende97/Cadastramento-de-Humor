<?php

// include autoloader
require_once '../lib/dompdf/autoload.inc.php';
require_once('../config.php');
require_once('../class/humor.class.php');

$dInicio = $_GET['dInicio'];
$dFim = $_GET['dFim'];
$email = $_GET['email'];


$list = $humor->listHumorByUser($dInicio, $dFim, $email);

use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de dados</title>
    
    <style>
        body{
            font-family: Helvetica, sans-serif;
        }

        p{
            font-size: 10px;
        }
        section#humor-list {
            float: none;
            box-shadow: 1px 1px 9px #33333357;
            border-radius: 4px;
            padding: 15px;
            border: 1px solid #69b3c3cf;
        }

        section#humor-list>div::-webkit-scrollbar-track {
            background-color: #237c86;
        }

        section#humor-list>div::-webkit-scrollbar-thumb {
            background-color: #fff;
            border-radius: 20px;
            border: none;
            height: 25px;
        }

        h1 {
            text-align: center;
            font-size: 20pt;
        }

        table,
        th,
        td {
            text-align: center;
            border-collapse: collapse;
        }

        th {
            background-color: rgba(150, 212, 212, 0.4);
            font-size: 12pt;
            padding: 15px;
        }

        td {
            padding: 25px 5px;
            font-size: 10pt;
        }

        tr {
            height: 70px;
        }
    </style>
</head>

<body id="pagina">
    <section id="humor-list">
        <h1>Listagem de dados</h1>
        <p>
            Usuário: <?php echo $email ?>
            <br>
            Relatório gerado em <?php echo date("j") . " de "
            . strftime('%B') . " de " . date("Y") ?>
        </p>
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

</body>

</html>
<?php
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper("A4"); //Define o tamanho do papel. A orientação "Portrait" já é padrão.
$dompdf->render();
$dompdf->stream("relatorio.pdf", ["Attachment" => false]);
// [Attachment" => false] faz com que o PDF seja exibido no navegador em vez de fazer o Download.