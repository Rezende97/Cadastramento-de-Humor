<?php

$password = $_POST['password'];

#importar classe db
require_once('../model/db.php');

#importar classe usuario
require_once('../class/user.class.php');

#instanciar classe database
$db = new Database;

#instancia classe usuario
$user = new User(
	$db->getConnection()
);

$passwd = sha1($password);

$result = $user->Login(
	htmlspecialchars($_POST['email']),
	htmlspecialchars($passwd)
);

if ($result != false) {

	session_start();
	$_SESSION['usuario'] = $_POST['email'];

	#define sessão de usuário
	$_SESSION['email'] = $result['email'];
	$_SESSION['id']    = $result['id'];
	$_SESSION['nivel'] = $result['nivel'];

	echo  "<strong>login sucedido:</strong> " . $result['email'];

	#caso campo tutorial for == 0 leve o usuário para o tutorial, contrario direcione à página de sistema
	if ($result['nivel'] < 1){
		if ($result['tutorial'] == 0) {
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
