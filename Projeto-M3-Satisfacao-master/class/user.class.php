<?php 

class User {

	private $conn;

	private $maximum_records = 13;

	private $nivel;


	public function __construct(PDO $conn) {
		$this->conn = $conn;
	}

	
	#retorna quantidade de registros atuais
	public function Count() {

		$stmt = $this->conn->prepare("SELECT count(email) FROM users");

		if($stmt->execute()) {

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			return $result['count(email)'];
		}

		return false;
	}


	public function Login($user, $passwd) {

		$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email and password = :password");

		$stmt->bindParam(":email", $user);
		$stmt->bindParam(":password", $passwd);

		$stmt->execute();

		if($stmt->rowCount() > 0){
			$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->nivel = $usuario['nivel'];
			return $usuario;
		} else {
			return false;
		}		
			
	}


	public function Register($user, $passwd) {

		// Limita quantidade de cadastro
		if($this->Count() >= $this->maximum_records) {
			return false;
		}

		$stmt = $this->conn->prepare("INSERT INTO users(email, password, nivel) VALUES(:email, :password, 0)");

		$stmt->bindParam(":email", $user);
		$stmt->bindParam(":password", $passwd);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function dataInicial($email){
		$stmt = $this->conn->prepare("SELECT DATE_FORMAT(MIN(humor.data), '%Y-%m-%d') from users JOIN humor ON users.id = humor.userID WHERE users.email = :email ");

		$stmt->bindParam(":email", $email);
		
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			$result = $stmt->fetch();
			return $result[0];
		}

	}

	public function listHumor($Inicio, $Fim) {

		$stmt = $this->conn->prepare("
			SELECT users.email, humor.userID, YEAR(humor.data), MONTH(humor.data), DAY(humor.data), humor.humor_initial, humor.humor_final, humor.comment_initial, humor.comment_final from users 
				JOIN humor
				ON users.id = humor.userID
			WHERE DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(:Inicio, '%d') AND DATE_FORMAT(:Fim, '%d');
		");

		$stmt->bindParam(':Inicio', $Inicio);
		$stmt->bindParam(':Fim', $Fim);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//Eu copiei a função "listHumor", mas vou estudar como fazer a sobreposição para evitar a repetição desse código
	public function listHumorAdmin($Inicio, $Fim, $email) {

		$stmt = $this->conn->prepare("
		SELECT users.email, humor.userID, YEAR(humor.data), MONTH(humor.data), DAY(humor.data), humor.humor_initial, humor.humor_final, 
		humor.comment_initial, humor.comment_final from users JOIN humor ON users.id = humor.userID WHERE users.email = 
		:email AND (DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(:Inicio, '%d') AND DATE_FORMAT(:Fim, '%d'))	");

		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':Inicio', $Inicio);
		$stmt->bindParam(':Fim', $Fim);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function listaEmails(){
		$sql = "SELECT ID, email FROM users";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	public function alteraNivel($email, $nivel){
		$sql = "UPDATE users SET nivel = :nivel WHERE users.email = :email";
		$stmt = $this->conn->prepare($sql);

		$stmt->bindParam(':nivel', $nivel);
		$stmt->bindParam(':email', $email);

		return $stmt->execute();
	}
}

?>