<?php 

require_once ('database.class.php');

class User {

	private $db;

	private $maximum_records = 13;


	public function __construct(concretDao $db) {
		$this->db = $db;
	}

	/**
	* @return bool
	*/	
	public function count() {
		return $this->db->query("SELECT count(email) FROM users")->select();
	}


	/**
	* @param user
	* @param paasswd
	*/
	public function Login($user, $passwd) {
		return $this->db->query('SELECT id, email, tutorial, nivel FROM users WHERE email = ? and password = ?')->select([$user, $passwd]);		
	}


	/**
	* @param user
	* @param paasswd
	*/
	public function register($user, $passwd){

		// Limita quantidade de cadastro
		if($this->count()[0]['count(email)'] >= $this->maximum_records) { 
			return false;
		}

		return $this->db->query('INSERT INTO users(email, password) VALUES(?, ?)')->insert([$user, $passwd]);
	}

	/**
	* @param $id
	*/
	public function setTutorial($userID) {
		return $this->db->query('UPDATE users SET tutorial = 1 WHERE id = ?')->update([$userID]);
	}	
}

$user = new User($db);

?>