<?php

require_once('../class/humor.class.php');
require_once('../class/admin.class.php');

$list = $admin->listaEmails();

?>

<h1 style="font-weight: bold">Contas de usuário</h1>

<section id="humor-list" style="width: 60%; margin-left: 20%;">
    <div id="list-user-table">
        <table style="width:100%">
            <tr>
                <th style="width: 50%;">Usuário</th>
                <th style="width: 50%;">Nível</th>
            </tr>
    
            <?php
            for ($i = 0; $i < sizeof($list); $i++) {
                $nivel = $list[$i]['nivel'] == 0 ? "Usuário padrão" : "Usuario Administrador";
            ?>
            <tr>
                <td><?php echo $list[$i]['email'] ?></td>
                <td><?php echo $nivel ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</section>