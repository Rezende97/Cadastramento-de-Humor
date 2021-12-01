<div class="container-data">
    <label for="d_Inicio">Data inicial:
        <input type="date" id="d_Inicio" name="d_Inicio" min=<?php echo $_POST['data'] ?> max=<?php echo date("Y-m-d") ?>>
    </label>
    <label for="d_Fim">Data final:
        <input type="date" id="d_Fim" name="d_Fim" min=<?php echo $_POST['data'] ?> max=<?php echo date("Y-m-d") ?>>
    </label>    
</div>