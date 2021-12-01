<?php 

require_once ('../config.php');

/**
** @param connect()
*/
interface Idatabase {
	public function connect();
}

class mysqlDatabase implements Idatabase {
	public function connect() {
		return new PDO("mysql:host=localhost;dbname=projeto_raiz", 'root', "");
	}
}

class sqliteDatabase implements Idatabase {
	public function connect() {
		$dbh  = new PDO('sqlite:../db.sqlite') or die("cannot open the database");
		return $dbh;
	}
}

/**
** @param insert()
** @param select()
** @param update()
** @param update()
*/
interface Dao {
	public function insert($data =[]);
	public function select($data =[]);
 	public function update($data =[]);
	public function delete($data =[]);	
}

class concretDao implements Dao {

	/**
	** @param $db
	*/
	private $db;
	private $query;

	/**
	** @param $db
	*/
	public function __construct($db) {
		$this->db = $db;
	}


	/**
	** @param $data[]
	*/
	public function insert($data = []) {
		$query = $this->query;
		$conexao = $this->db->connect();
		$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conexao->prepare($query);
		return $stmt->execute($data);
	}

	/**
	** @param $data[]
	*/
	public function select($data = []) {
		$query = $this->query;
		$conexao = $this->db->connect();
		$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conexao->prepare($query);
		$stmt->execute($data);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);		
	}

	/**
	** @param $data[]
	*/
 	public function update($data = []) {
		$query = $this->query;
		$stmt = $this->db->connect()->prepare($query);
		return $stmt->execute($data);		
 	}

	public function delete($data = []) {}

	/**
	** @param $query
	*/
	public function query($query) {
		$this->query = $query;
		return $this;
	}			
}

$db = (DATABASE == 'mysql') ? new concretDao( new mysqlDatabase ) : new concretDao( new sqliteDatabase );

?>