<?php
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tutorial - Radar da felicidade</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/tutorial.css">
</head>

<body>
	<header>
		<div id="brand"><a href="index.php"><i class="fas fa-broadcast-tower"></i></a></div>
		<div id="painel"> 
			<span class="email"><small><?php echo $_SESSION['usuario']; ?></small></span>
			<span><a href="../auth/logout.php">Logout.</a></span>			
		</div>
	</header>	
	<main>
		<div class="container">
			<div class="row" id="center">
				<div class="col-sm-12 col-md-10">
					<section id="tutorial">
						<div>
							<h2><span class="title">Tutorial</span></h2>
						</div>

						<div class="step" data-bs-toggle="tooltip">
							<p class="alert alert-info">
								<span class="titulo-destaque">1º passo:</span> Após fazer o login, você verá a tela para a escolha do seu humor inicial/final. O humor inicial é o humor que você estará sentindo no primeiro período da sua jornada de trabalho diária.
							</p>				
							<img src="../imagem/tutorial/tutorial_1.png" data-bs-placement="top" title="Tela de seleção do humor">			
						</div>

						<div class="step">
							<p class="alert alert-info">
								<span class="titulo-destaque">2º passo:</span> Para selecionar seu humor, basta clicar em cima da área em azul, correspondente ao humor desejado. Após selecionar, o campo escolhido mudará de cor, como mostrado na imagem a seguir:
							</p>							
							<div style="width: 40%; margin: auto;"><img src="../imagem/tutorial/tutorial_2.gif" data-bs-placement="top" title="Esquema de seleção do humor"></div>
						</div>	

						<div class="step">
							<p class="alert alert-info">
								<span class="titulo-destaque">Observação:</span> Repare que você poderá marcar o campo “Incluir comentário” caso queira adicionar um comentário sobre seu humor.
							</p>							
							<img src="../imagem/tutorial/tutorial 4.gif" data-bs-placement="top" title="Esquema para inserir comentário">			
						</div>	

						<div class="step">
							<p class="alert alert-info">
								<span class="titulo-destaque">3º passo:</span> Após a seleção, basta clicar no botão enviar para fazer o registro do humor. Ao finalizar, a seguinte página será exibida:
							</p>					
							<img src="../imagem/tutorial/tutorial_5.png" data-bs-placement="top" title="Confirmação do registro de humor">				
						</div>	
						<div class="step">
							<p class="alert alert-info">
								Pronto. Seu humor foi registrado no banco de dados. Não se esqueça de registrar seu humor final no final do seu expediente.
							</p>				
						</div>
						<div id="btn_seguir">
							<p>
								<a  class="btn btn-success text-center" href="../home/index.php?finish_tutorial=true">Seguir página</a>
							</p>				
						</div>																		
					</section>					
				</div>
			</div>
		</div>
	</main>
	<footer>
		<section id="help" >
			<div class="help-form">
				<div style="text-align: center;"><span style="color: #ffffff;">Possui alguma dúvida?</span></div>
				<form action="enviaduvida.php" method="post">
					<div><textarea name="message"></textarea></div>
					<div><button class="btn btn-primary" type="submit">Enviar dúvida</button></div>
				</form>
			</div>
		</section>		
	</footer>
</body>

</html>