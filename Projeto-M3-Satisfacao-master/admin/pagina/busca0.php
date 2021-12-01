<?php

require_once('../model/db.php');
require_once('../class/user.class.php');
require_once('config.php');

?>

<h1 style="font-weight: bold">Listar humor por usuário e por período</h1>

<form action="consulta_admin.php?order=user" method="post">
    <div id="users">
        <label>Usuário:
            <select name="email" id="lista" class="form-select" aria-label="example">
                <?php
                foreach ($emails as $id => $valor) {
                    echo "<option value='" . $valor['email'] . "'>" . $valor['email'] . "</option>";
                }
                ?>
            </select>
        </label>
    </div>
    <div id="data"></div>
</form>

<script>
        var select = document.getElementById('lista');
        select.addEventListener("change", selecionarEmail);

        function selecionarEmail() {
            var valor = select.options[select.selectedIndex].value;

            $.ajax({
                method: "POST",
                url: "atualiza.php",
                data: {
                    email: valor
                },
                success: function(e) {
                    $('#data').load('render_data.php', {data: e});
                }

            })
        }

        selecionarEmail();
    </script>