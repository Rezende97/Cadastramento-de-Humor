<?php 

require_once ('database.class.php');

class example {

	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function Count() {
		return $this->db->query("SELECT count(email) FROM users")->select();
	}

	public function dataInicial($email){

		if(DATABASE == 'mysql') {
			$query = "SELECT DATE_FORMAT(MIN(humor.data), '%Y-%m-%d') from users JOIN humor ON users.id = humor.userID WHERE users.email = ?";
		} else if (DATABASE == 'sqlite') {
			$query = "SELECT strftime('%Y-%m-%d', MIN(humor.data)) from users JOIN humor ON users.id = humor.userID WHERE users.email = ?";
		}

		return $this->db
			->query($query)
			->select($email);
	}	

	// exemplo consulta insert
	public function Register($user = []) {
		return $this->db
			->query(
				'INSERT INTO users(email, password) 
				VALUES(?,?)
			')->insert($user);
	}

	// exemplo consulta select
	public function Login($user, $passwd) {
		return $this->db
			->query('SELECT id, email FROM users WHERE email = ? and password = ?')
			->select([$user, $passwd]);
	}

	// exemplo consulta update
	public function updateHumor($userID, $humor, $comment, $day) {

		if(DATABASE == 'mysql') {
			$query = "UPDATE humor SET humor_final = ?, comment_final = ? WHERE userID = ? and DATE_FORMAT(data, '%d') = ?;";
		} else if(DATABASE == 'sqlite') {
			$query = "UPDATE humor SET humor_final = ?, comment_final = ? WHERE userID = ? and strftime('%d', data) = ?;";
		}
	
		return $this->db->query($query)
			->update([$humor, $comment, $userID, $day]);
	}

    // exemplo consulta complexa usando select
    public function listHumorByUser($inicio, $fim, $email) {

    	if(DATABASE == 'mysql') {
			$query = "SELECT 
	        	humor.userID, 
	        	DATE_FORMAT(humor.data, '%Y') as YEAR,
	        	DATE_FORMAT(humor.data, '%M') as MONTH,
	        	DATE_FORMAT(humor.data, '%D') as DAY, 
	        	humor.humor_initial, 
	        	humor.humor_final, 
	        	humor.comment_initial, 
	        	humor.comment_final FROM users JOIN humor on users.id = humor.userID 
	        	WHERE users.email = ? AND 
	        	DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(?, '%d') AND 
	        	DATE_FORMAT(?, '%d')
	        ";
    	} else if(DATABASE == 'sqlite') {
	        $query = "SELECT 
	        	humor.userID, 
	        	strftime('%Y', humor.data) as YEAR,
	        	strftime('%M', humor.data) as MONTH,
	        	strftime('%D', humor.data) as DAY, 
	        	humor.humor_initial, 
	        	humor.humor_final, 
	        	humor.comment_initial, 
	        	humor.comment_final FROM users JOIN humor on users.id = humor.userID 
	        	WHERE users.email = ? AND 
	        	strftime('%d', data) BETWEEN strftime('%d', ?) AND 
	        	strftime('%d', ?);
	        ";
    	}

        return $this->db
        	->query($query)
        	->select([$email, $inicio, $fim]);
    }	
}

$object = new example($db);


?>