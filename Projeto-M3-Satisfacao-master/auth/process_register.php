<?php 

//verificação do e-mail
if(!preg_match('/^[a-z0-9.\-\_]+@[a-z0-9.\-\_]+\.(com|br|com.br|net)$/i', $_POST['email'])){
	die("E-mail inválido");
}

$password = $_POST['password'];
$repassword = $_POST['repassword'];

$comp = strcmp($password, $repassword); //método para comparar se as senhas são iguais

if($comp == 0){
	//preg_match defini os requisitos para a senha, com números, letras e caracteres especiais
	if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)){	
		die("Senha inválida. A senha deve conter números, letras e ou caracteres especiais do tamanha de 8 a 12 caracteres");
	  }
}else{
	die("As senhas digitadas não são iguais");
}
#importar classe db
require_once ('../model/db.php');

#importar classe usuario
require_once ('../class/user.class.php');

#instanciar classe database
$db = new Database;

#instancia classe usuario
$user = new User(
	$db->getConnection()
);

//criptografia de senha
$passwd = sha1($password);

$result = $user->Register(
	htmlspecialchars($_POST['email']),
	htmlspecialchars($passwd)
);

if($result != false) {
	echo "registro sucedido!";
	?>
	<br>
	<a href="../index.html">Página inicial</a>
	<?php
} else {
	echo "falha no registro, número maximo excedido!";
	?>
	<br>
	<a href="../index.html">Página inicial</a>
	<?php
}

?>