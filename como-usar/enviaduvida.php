<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    if (isset($_POST['message'])){
        
        require_once ('../model/db.php');

	      $db = new Database();

        $id = $_SESSION['id'];

        $comment = $_POST['message'];
        
        $insere = $db->getConnection()->prepare('INSERT INTO help(userID, comment) VALUES(:id, :comment)');
        $insere->bindParam(":id", $id);
        $insere->bindParam(":comment", $comment);
        $insere->execute();
    }   
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Envio</title>
		<link rel="stylesheet" href="">
	</head>
	<body style="text-align: center;">
		 <h2>Dúvida registrada</h2>
   		<p><a href="../home/index.php">Seguir</a></p>   		
	</body>
</html>