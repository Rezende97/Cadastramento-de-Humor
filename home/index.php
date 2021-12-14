<?php

require_once ('../config.php');

// checa sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['usuario'])) {
	header('location: ../index.html');
}

if (isset($_GET['finish_tutorial']) && $_GET['finish_tutorial'] == true) {

	require_once ('../class/user.class.php');

	$user->setTutorial($_SESSION['id']);
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Início - Radar da felicidade</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
	<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
				<div class="col-sm-10 pt">
					<div style="padding: 25px;"><h5>Selecione humor</h5></div>

					<form class="form-check" id="form-humor">

						<div id="fields">
							<label class="field" data-select="0">
								<div class="input-field"><input type="radio" id="Feliz" name="humor" value="1" class="radio_card"  data-select="0"></div>
								<div class="card-text">Feliz &#128515;</div>
							</label>
							<label class="field" data-select="1">
								<div class="input-field"><input type="radio" id="Neutro" name="humor" value="2" class="radio_card" data-select="1"></div>
								<div class="card-text">Neutro &#x1F610;</div>						
							</label>
							<label class="field" data-select="2">
								<div class="input-field"><input type="radio" id="Triste" name="humor" value="3" class="radio_card" data-select="2"></div>
								<div class="card-text">Triste &#128549;</div>																
							</label>						
						</div>

						<div>
							<label>
								<input type="checkbox" name="checkbox_comment" onclick="enableComment()" id="checkComment">
								&nbsp;Incluir comentário
							</label>
						</div>

						<div>
							<input type="text" class="form-control mb-3" id="comment" name="comment" placeholder="Digite o que você está sentindo." disabled>
						</div>
						<div>
							<button id="submit" type="submit" class="btn btn-primary btn-lg btn-large" disabled>Enviar</button>
						</div>
					</form>
					<p>
						<br>
						<a class="btn btn-info btn-large" style="width:300px;" href="busca.php">Resultados</a>
					</p>
				</div>
			</div>
			<div id="relogio">
				<script language="JavaScript">
					function showtime() {
						setTimeout("showtime();", 1000);
						callerdate.setTime(callerdate.getTime() + 1000);
						var hh = String(callerdate.getHours());
						var mm = String(callerdate.getMinutes());
						var ss = String(callerdate.getSeconds());
						document.clock.face.value =
							((hh < 10) ? " " : "") + hh +
							((mm < 10) ? ":0" : ":") + mm +
							((ss < 10) ? ":0" : ":") + ss;

					}
					callerdate = new Date(<?php
											date_default_timezone_set('America/Sao_Paulo');
											echo date("Y,m,d,H,i,s"); ?>);
				</script>

				<body onLoad="showtime()">
					<form name="clock" id="clock"><input type="text" name="face" value="" size=15></form>
			</div>
			<div style="display: none">
				<?php
				date_default_timezone_set('America/Sao_Paulo');
				echo date('d/m/Y às H:i:s');
				?>
			</div>

		</div>		
	</main>	
	<script type="text/javascript" src="../js/humor.js"></script>
</body>

</html>