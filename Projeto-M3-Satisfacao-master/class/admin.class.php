<?php
    class admin {
        
        private $conn;

        public function __construct(PDO $conn){
            $this->conn = $conn;
        }

        public function listar($user, $inicio, $fim){
            $stmt = this->conn->prepare("SELECT humor.data, humor.schedule, humor.humor, humor.comment FROM users join humor on users.id = humor.userID WHERE users.email =  :email and  humor.data BETWEEN :dInicial . "00\:00\:00" and :dFinal . "23:59:59"");

            $stmt->bindParam(":email", $user);
            $stmt->bindParam(":dInicial", $inicio);
            $stmt->bindParam(":dFinal", $fim);

            $smt->execute();
        }


    }
