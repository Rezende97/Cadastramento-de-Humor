<div class="container-data">
    <label for="d_Inicio">Data inicial:
        <input type="date" class="verificaData"  id="d_Inicio" name="d_Inicio" min=<?php echo $_POST['data'] ?> max=<?php echo date("Y-m-d") ?>>
    </label>
    <label for="d_Fim">Data final:
        <input type="date" class="verificaData" id="d_Fim" name="d_Fim" min=<?php echo $_POST['data'] ?> max=<?php echo date("Y-m-d") ?>>
    </label>
    <div id="mensagem"></div>
    <div class="container-btn-submit"><button type="submit" id="enviar" class="btn btn-primary">Consultar</button></div>
   
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
                   document.getElementById("mensagem").innerHTML = "<p style='font-size: small; color: red'>A data final não pode ser menor que a inicial</p>";
                } else{
                    botao.disabled = false;
                    document.getElementById("mensagem").innerHTML = "";
                }
            }
        }
        
    </script>
</div>