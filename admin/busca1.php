
<h1 style="font-weight: bold">Listar humor apenas por período</h1>
<p>
    Esta pesquisa retornará a listagem dos humores de todos os usuários registrados
    no intervalo da data inicial e final.
</p>

<?php 
    $dInicio = ($humor->dataInicial() !== "") ? $humor->dataInicial() : date("Y-m-d");
    $dFim = date("Y-m-d");
     ?>
     
<form action="consulta_admin.php?order=date" method="post">
    <div class="container-data">
        <label>Data inicial:
            <input type="date" class="verificaData" id="d_Inicio" name="d_Inicio" min="<?php echo $dInicio[0]['data'] ?>" max="<?php echo $dFim ?>">
        </label>
        <p>
        <label>Data final:
            <input type="date"  class="verificaData" id="d_Fim" name="d_Fim" min="<?php echo $dInicio[0]['data'] ?>" max="<?php echo $dFim ?>">
        </label>
    </div>
    <div id="mensagem"></div>
    <div class="container-btn-submit"><button type="submit" id="enviar" class="btn btn-primary">Consultar</button></div>
</form>

<script>
       var botao = document.getElementById('enviar');
       botao.disabled = true;

        Array.from(document.getElementsByClassName('verificaData')).forEach(function(data){
            data.addEventListener('change', check);
            console.log(data);
        })
        
        
        function check(e){
            
            var inicial = document.getElementById('d_Inicio').value;
            var final = document.getElementById('d_Fim').value;
            if (inicial != "" && final != ""){
                if(final < inicial){
                    botao.disabled = true;
                   document.getElementById("mensagem").innerHTML = "<p style='font-size: small; color: red'>A data final não pode ser menor que a inicial</p>";
                } else{
                    botao.disabled = false;
                    document.getElementById("mensagem").innerHTML = "";
                }
            }
        }
        
    </script>