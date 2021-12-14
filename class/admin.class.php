<?php

require_once ('database.class.php');

class admin {
    
    private $db;

    public function __construct(concretDao $db){
        $this->db = $db;
    }

    /**
    * @param $email
    * @param $nivel
    */
    public function alteraNivel($email, $nivel){
        return $this->db->query("UPDATE users SET nivel = ? WHERE users.email = ?")->update([$nivel, $email]);
    }

    /**
    * @return email[]
    */
    public function listaEmails(){
        return $this->db->query("SELECT ID, email, nivel FROM users")->select();
    }
}

$admin = new admin($db);

?>