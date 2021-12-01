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

require_once('../model/db.php');
require_once('../class/user.class.php');
require_once('pagina/config.php');

?>
    <h1 style="font-weight: bold">Alterar contas de usuário</h1>

    <p>
        Selecione abaixo a conta de usuário para alterar para usuário administrador ou usuário padrão:
    </p>

    <form action="home.php" method="get">
        <label>Usuário:
            <select name="usr" id="lista" class="form-select">
                <?php
                foreach ($emails as $id => $valor) {
                    echo "<option value='" . $valor['email'] . "'>" . $valor['email'] . "</option>";
                }
                ?>
            </select>
        </label>

        <input type="hidden" name="p" value="contas"></input>

        <p>Alterar para:</p>

        <label>Nível
            <select name="nivel" class="form-select">
                <option value="1">Administrador</option>
                <option value="0">Usuário padrão</option>
            </select>
        </label>
        <br>
        <button class="btn btn-primary mb-2" type="submit">Alterar</button>

    </form>

    <div id="res"></div>

<?php

if (isset($_GET['usr']) && isset($_GET['nivel'])) {

    $usr = $_GET['usr'];
    $nivel = $_GET['nivel'];

    if ($user->alteraNivel($usr, $nivel)) {
        ?>
        <script>
            document.getElementById("res").innerHTML = "<p style='color: #32CD32'>Alteração efetuada com sucesso!</p>";
        </script>
        <?php
    } else {
        ?>
        <script>
            document.getElementById("res").innerHTML = "<p style='color: red'>Erro. Alteração não efetuada!</p>";
        </script>
        <?php 
    }
}

?>