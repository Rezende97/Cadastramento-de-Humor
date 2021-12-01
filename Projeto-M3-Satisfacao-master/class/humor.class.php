<?php

    class Humor{

        private $conn;

        private $initial = [];

        private $final = [];

        public function __construct(PDO $conn) {
            $this->conn = $conn;
        }

        // insere humor na base
        public function insertHumor($day, $id, $periodo, $humor, $comment){

            if($this->checkRegister($id, $periodo, $day) == false) {
                return false;
            }


            switch($periodo) {
                case 1:                    
                    // insere humor de manhã
                    $stmt = $this->conn->prepare("
                        INSERT INTO humor(userID, humor_initial, humor_final, comment_initial, comment_final) 
                        VALUES(:user, :humor_initial, null, :first_comment, null)
                    ");
                    $stmt->bindParam(':user', $id);
                    $stmt->bindParam(':humor_initial', $humor);
                    $stmt->bindParam(':first_comment', $comment);
                    $stmt->execute();
                    return true;
                    break;
                case 2: 
                    // tenta selecionar registro de humor na tabela
                    $stmt = $this->conn->prepare("SELECT id FROM humor WHERE userID = :user and DATE_FORMAT(data, '%d') = :day");
                    $stmt->bindParam(':user', $userId);
                    $stmt->bindParam(':day', $data);
                    $stmt->execute();

                    if($stmt->rowCount() == 0) {
                        // Cria novo registro
                        $stmt = $this->conn->prepare("
                            INSERT INTO humor(userID, humor_final, comment_final) 
                            VALUES(:user, :humor_final, :last_comment)
                        ");
                        $stmt->bindParam(':user', $id);
                        $stmt->bindParam(':humor_final', $humor);
                        $stmt->bindParam(':last_comment', $comment);
                        $stmt->execute();
                        return true; 
                    } else {
                        //atualiza registro
                        $stmt = $this->conn->prepare("
                            UPDATE humor 
                            SET humor_final = :humor_final, 
                            comment_final = :comment_final 
                            WHERE userID = :user and DATE_FORMAT(data, '%d') = :data
                        ");
                        $stmt->bindParam(':humor_final', $humor);
                        $stmt->bindParam(':comment_final', $comment);
                        $stmt->bindParam(':user', $id);
                        $stmt->bindParam(':data', $day);
                        $stmt->execute();
                        return true;                         
                    }                  
                    break;
            }
        }

        // listar humor individual do usuário
        public function listHumorByUser($Inicio, $Fim, $email) {

            $stmt = $this->conn->prepare("
                SELECT 
                humor.userID, 
                YEAR(humor.data), 
                MONTH(humor.data), 
                DAY(humor.data), 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users JOIN humor ON users.id = humor.userID 
                WHERE users.email = :email AND 
                (DATE_FORMAT(data, '%d') BETWEEN DATE_FORMAT(:Inicio, '%d') AND DATE_FORMAT(:Fim, '%d'))
            ");

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':Inicio', $Inicio);
            $stmt->bindParam(':Fim', $Fim);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // verifica se hora atual está entre horario de envio do humor
        public function checkHour($hour) {

            // horários periodos inicial/final
            $initial = $this->initial;
            $final = $this->final;

            if($hour >= $initial[0] && $hour < $initial[1]) {
                return 1;
            } else if($hour >= $final[0] && $hour < $final[1]) {       
                return 2;
            } 
            return false;                     
        }

        // verifica se humor foi enviado
        public function checkRegister($userId, $schedule, $data) {

            switch($schedule) {
                case 1:
                    $query = "SELECT id FROM humor WHERE userID = :user and DATE_FORMAT(data, '%d') = :day and humor_initial IS NOT NULL";  
                    break;
                case 2:
                    $query = "SELECT id FROM humor WHERE userID = :user and DATE_FORMAT(data, '%d') = :day and humor_final IS NOT NULL";  
                    break;                
            }

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user', $userId);
            $stmt->bindParam(':day', $data);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return false;
            } else {
                return true;
            }         
        }

        public function formatHumor($humorID) {
            switch ($humorID) {
                case 1:
                    return 'Feliz';
                    break;
                case 2:
                    return 'Neutro';
                    break;
                case 3:
                    return 'Triste';
                    break; 
                default:
                    return 'null';
                    break;                                       
            }
        }

        public function setInitialTime($initial, $final) {
            $this->initial[0] = $initial;
            $this->initial[1] = $final;
        }

        public function setFinalTime($initial, $final) {
            $this->final[0] = $initial;
            $this->final[1] = $final;
        }        
    }

    $humor = new Humor($pdo);

    /*
    ** Primeiro período entre 06horas e 12horas
    ** Segundo período entre 13horas e 17horas
    */
    $humor->setInitialTime(HUMOR_INICIAL_INI, HUMOR_INICIAL_FIM);
    $humor->setFinalTime(HUMOR_FINAL_INI, HUMOR_FINAL_FIM); 
?>