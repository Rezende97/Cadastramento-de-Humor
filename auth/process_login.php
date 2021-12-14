<?php

if(!isset($_SESSION)) session_start();

$password = $_POST['password'];

#importar classe db
// require_once('../model/db.php');

#importar classe usuario
require_once('../class/user.class.php');

$passwd = sha1($password);

$result = $user->Login(
	htmlspecialchars($_POST['email']),
	htmlspecialchars($passwd)
);

if ($result != false) {

	$user = $result[0];

	$_SESSION['usuario'] = $_POST['email'];

	#define sessão de usuário
	$_SESSION['email'] = $user['email'];
	$_SESSION['id']    = $user['id'];
	$_SESSION['nivel'] = $user['nivel'];

	echo  "<strong>login sucedido:</strong> " . $user['email'];

	#caso campo tutorial for == 0 leve o usuário para o tutorial, contrario direcione à página de sistema
	if ($user['nivel'] < 1){
		if ($user['tutorial'] == 0) {
			header('location: ../como-usar/index.php?step=1');
		} else {
			header('refresh: 3, ../home/index.php');
		}
	} else{
		header('location: ../admin/home.php?p=inicio');
	}
} else {
	?>
	<script>
		alert("falha no login, usuario ou senha incorretos!");
		window.location.href = "../index.html";
	</script>
  
	<?php 
}
?>
