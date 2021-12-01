<?php 

require_once ('database.class.php');

class User {

	private $db;

	private $maximum_records = 13;

	private $nivel;


	public function __construct($db) {
		$this->db = $db;
	}

	/**
	*	@return bool
	*/	
	public function count() {
		return $this->db->query("SELECT count(email) FROM users")->select();
	}


	/**
	*	@param user
	* 	@param paasswd
	*/
	public function Login($user, $passwd) {
		return $this->db->query('SELECT id, email FROM users WHERE email = ? and password = ?')->select([$user, $passwd]);		
	}


	public function register($user, $passwd){

		// Limita quantidade de cadastro
		if($this->count()[0]['count(email)'] >= $this->maximum_records) { 
			return false;
		}

		return $this->db->query('INSERT INTO users(email, password) VALUES(?, ?)')->insert([$user, $passwd]);
	}

	
	public function dataInicial($email){

		if(DATABASE == 'mysql') {
			$query = "SELECT DATE_FORMAT(MIN(humor.data), '%Y-%m-%d') from users JOIN humor ON users.id = humor.userID WHERE users.email = ?";
		} else if (DATABASE == 'sqlite') {
			$query = "SELECT strftime('%Y-%m-%d', MIN(humor.data)) from users JOIN humor ON users.id = humor.userID WHERE users.email = ?";
		}

		return $this->db->query($query)->select([$email]);
	}

	public function listHumor($inicio, $fim) {
		if(DATABASE == 'mysql'){
			$query = "SELECT users.email, humor.userID, YEAR(humor.data) as year, MONTH(humor.data) as month, DAY(humor.data) as day, humor.humor_initial, humor.humor_final, humor.comment_initial, humor.comment_final from users 
				JOIN humor ON users.id = humor.userID WHERE DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(?, '%d') AND DATE_FORMAT(?, '%d')";
		} else if (DATABASE == 'sqlite'){
			$query = "SELECT users.email, humor.userID, strftime('%Y', humor.data) as year, strftime('%m', humor.data) as month, strftime('%d', humor.data) as day, humor.humor_initial, humor.humor_final, humor.comment_initial, humor.comment_final from users
				JOIN humor ON users.id = humor.userID WHERE strftime('%d', humor.data) BETWEEN strftime('%d', ?) AND strftime('%d', ?)";
		}
		
		return $this->db->query($query)->select([$inicio, $fim]);
	}

	//Eu copiei a função "listHumor", mas vou estudar como fazer a sobreposição para evitar a repetição desse código
	public function listHumorAdmin($email, $inicio, $fim) {
		if(DATABASE == 'mysql'){
			$query = "SELECT users.email, humor.userID, YEAR(humor.data) as year, MONTH(humor.data) as month, DAY(humor.data) as day, humor.humor_initial, humor.humor_final, 
		humor.comment_initial, humor.comment_final from users JOIN humor ON users.id = humor.userID WHERE users.email = 
		? AND (DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(?, '%d') AND DATE_FORMAT(?, '%d'))";
		} else if (DATABASE == 'sqlite'){
			$query = "SELECT users.email, humor.userID, strftime('%Y', humor.data) as year, strftime('%m', humor.data) as month, strftime('%d', humor.data) as day, humor.humor_initial, humor.humor_final, 
			humor.comment_initial, humor.comment_final from users JOIN humor ON users.id = humor.userID WHERE users.email = 
			? AND (strftime('%d', humor.data) BETWEEN strftime('%d', ?) AND strftime('%d', ?))";
		}
		
		return $this->db->query($query)->select([$email, $inicio, $fim]);
	}

	public function listaEmails(){
		$sql = "SELECT ID, email FROM users";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	public function alteraNivel($email, $nivel){
		$sql = "UPDATE users SET nivel = :nivel WHERE users.email = :email";
		$stmt = $this->db->prepare($sql);

		$stmt->bindParam(':nivel', $nivel);
		$stmt->bindParam(':email', $email);

		return $stmt->execute();
	}
}

$user = new User($db);

?>