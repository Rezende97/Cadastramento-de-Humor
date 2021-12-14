<?php
    
require_once ('database.class.php');

class Humor{

    private $db;

    private $initial = [];

    private $final = [];

    public function __construct(concretDao $db) {
        $this->db = $db;
    }


    /**
    * Insere humor
    * @param $day
    * @param $id
    * @param $periodo
    * @param $humor
    * @param $comment
    */
    public function insertHumor($day, $id, $periodo, $humor, $comment){

        if($this->checkRegister($id, $periodo, $day) == false) {
            return false;
        }

        switch($periodo) {
            case 1:            
                return $this->db->query("
                    INSERT INTO humor(userID, humor_initial, humor_final, comment_initial, comment_final) 
                    VALUES(?, ?, null, ?, null)
                ")->insert([$id, $humor, $comment]);
            break;
            case 2:
                if(DATABASE == 'mysql') {
                    $query = "SELECT id 
                        FROM humor WHERE userID = ? and DATE_FORMAT(data, '%Y-%m-%d') = ?
                    ";
                } else if (DATABASE == 'sqlite') {
                    $query = "SELECT id 
                        FROM humor WHERE userID = ? and strftime('%Y-%m-%d', data) = ?
                    ";
                } 

                // tenta selecionar registro de humor na tabela
                $result = $this->db->query($query)->select([$id, $day]);

                if(empty($result)) {
                    // Cria novo registro
                    return $this->db->query("
                        INSERT INTO humor(userID, humor_final, comment_final) 
                        VALUES(?, ?, ?)
                    ")->insert([$id, $humor, $comment]);
                } else {
                    if(DATABASE == 'mysql') {
                        $query = "UPDATE humor 
                            SET humor_final = ?, 
                            comment_final = ?
                            WHERE userID = ? and DATE_FORMAT(data, '%Y-%m-%d') = ?
                        ";
                    } else if (DATABASE == 'sqlite') {
                        $query = "UPDATE humor 
                            SET humor_final = ?, 
                            comment_final = ?
                            WHERE userID = ? and strftime('%Y-%m-%d', data) = ?
                        ";
                    }
                    return $this->db->query($query)->update([$humor, $comment, $id, $day]);                 
                }
            break;
        }
    }

    /**
    * Lista humor do usuário selecionado
    * @return humor[]
    * @param $email
    * @param $inicio
    * @param $fim
    */
    public function listHumorAdmin($email, $inicio, $fim) {

        if(DATABASE == 'mysql'){
            $query = "SELECT 
                users.email, 
                humor.userID, 
                YEAR(humor.data) as year, 
                MONTH(humor.data) as month, 
                DAY(humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users 
                JOIN humor ON users.id = humor.userID 
                WHERE 
                users.email = ? AND 
                (DATE_FORMAT(data, '%Y-%m-%d') BETWEEN DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(?, '%Y-%m-%d'))
                ORDER BY humor.data ASC";
        } else if (DATABASE == 'sqlite'){
            $query = "SELECT
                users.email, 
                humor.userID, 
                strftime('%Y', humor.data) as year, 
                strftime('%m', humor.data) as month, 
                strftime('%d', humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users 
                JOIN humor ON users.id = humor.userID 
                WHERE 
                users.email = ? AND 
                (strftime('%Y-%m-%d', humor.data) BETWEEN strftime('%Y-%m-%d', ?) AND strftime('%Y-%m-%d', ?))
                ORDER BY humor.data ASC";
        }
        
        return $this->db->query($query)->select([$email, $inicio, $fim]);
    }


    /**
    * Lista humor selecionado por período 
    * @return humor[]
    * @param $inicio
    * @param $fim
    */
    public function listHumor($inicio, $fim) {
        if(DATABASE == 'mysql'){
            $query = "SELECT 
                users.email, 
                humor.userID, 
                YEAR(humor.data) as year, 
                MONTH(humor.data) as month, 
                DAY(humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users 
                JOIN humor ON users.id = humor.userID 
                WHERE 
                DATE_FORMAT(data, '%Y-%m-%d') BETWEEN DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(?, '%Y-%m-%d')
                ORDER BY humor.data ASC";
        } else if (DATABASE == 'sqlite'){
            $query = "SELECT 
                users.email, 
                humor.userID, 
                strftime('%Y', humor.data) as year, 
                strftime('%m', humor.data) as month, 
                strftime('%d', humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users
                JOIN humor ON users.id = humor.userID 
                WHERE 
                strftime('%Y-%m-%d', humor.data) BETWEEN strftime('%Y-%m-%d', ?) AND strftime('%Y-%m-%d', ?)
                ORDER BY humor.data ASC";
        }
        
        return $this->db->query($query)->select([$inicio, $fim]);
    }  


    /**
    * Lista humor individual de usuário comum
    * @return humor[]
    * @param $inicio
    * @param $fim
    * @param $email 
    */
    public function listHumorByUser($inicio, $fim, $email) {

        if(DATABASE == 'mysql') {
            $query = "SELECT 
                humor.userID, 
                YEAR(humor.data) as year, 
                MONTH(humor.data) as month, 
                DAY(humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users 
                JOIN humor ON users.id = humor.userID 
                WHERE 
                users.email = ? AND 
                (DATE_FORMAT(data, '%Y-%m-%d') BETWEEN DATE_FORMAT(?, '%Y-%m-%d') AND DATE_FORMAT(?, '%Y-%m-%d'))
                ORDER BY humor.data ASC";            
        } else if(DATABASE == 'sqlite') {
            $query = "SELECT 
                humor.userID, 
                strftime('%Y', humor.data) as year, 
                strftime('%m', humor.data) as month, 
                strftime('%d', humor.data) as day, 
                humor.humor_initial, 
                humor.humor_final, 
                humor.comment_initial, 
                humor.comment_final 
                from users JOIN humor ON users.id = humor.userID 
                WHERE users.email = ? AND 
                (strftime('%d', data) BETWEEN strftime('%d', ?) AND strftime('%d', ?))
                ORDER BY humor.data ASC"; 
        }

        return $this->db->query($query)->select([$email, $inicio, $fim]);
    }


    /**
    * Retorna data da primeira inserção de humor
    * @return date
    * @return date
    * @param $email
    */  
    public function dataInicial($email = ""){

        if(DATABASE == 'mysql') {
            $query = "SELECT 
                DATE_FORMAT(MIN(humor.data), '%Y-%m-%d') as data 
                from users 
                JOIN humor ON users.id = humor.userID
            ";
                
            if(!empty($email)){
                $query = "SELECT 
                    DATE_FORMAT(MIN(humor.data), '%Y-%m-%d') as data 
                    from users 
                    JOIN humor ON users.id = humor.userID 
                    WHERE users.email = ?
                ";
                return $this->db->query($query)->select([$email]);
            }    
        } else if (DATABASE == 'sqlite') {
                
            $query = "SELECT 
            strftime('%Y-%m-%d', MIN(humor.data)) as data 
            from users 
            JOIN humor ON users.id = humor.userID";
           
            if (!empty($email)){
                $query = "SELECT 
                    strftime('%Y-%m-%d', MIN(humor.data)) as data 
                    from users 
                    JOIN humor ON users.id = humor.userID 
                    WHERE users.email = ?
                ";
                return $this->db->query($query)->select([$email]);
            }
        }

        return $this->db->query($query)->select();
    }


    /**
    * Checa se existe registro do humor 
    * @return bool
    * @param $userId
    * @param $schedule
    * @param $data
    */  
    public function checkRegister($userId, $schedule, $data) {

        if(DATABASE == 'mysql') {
            $query = "SELECT id FROM humor WHERE userID = ? AND DATE_FORMAT(data, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d')"; 
        } else if(DATABASE == 'sqlite') {
            $query = "SELECT id FROM humor WHERE userID = ? AND strftime('%Y-%m-%d', data) = strftime('%Y-%m-%d', ?)";           
        }

        if($schedule == 1) {
            $query .=  "and humor_initial IS NOT NULL";
        } else {
            $query .=  "and humor_final IS NOT NULL";                
        }

        return $isEmpty = (empty($this->db->query($query)->select([$userId, $data]))) ? true : false;
    }


    /**
    * Retorna texto humor
    * @param $humorID
    */ 
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

    /**
    * Retorna número período
    * @param $hour
    */ 
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


    /**
    * Configura horário de inicio e termino
    * @param $initial
    * @param $final
    */ 
    public function setInitialTime($initial, $final) {
        $this->initial[0] = $initial;
        $this->initial[1] = $final;
    }


    /**
    * Configura horário de inicio e termino
    * @param $initial
    * @param $final
    */ 
    public function setFinalTime($initial, $final) {
        $this->final[0] = $initial;
        $this->final[1] = $final;
    }        
}

$humor = new Humor($db);

$humor->setInitialTime(HUMOR_INICIAL_INI, HUMOR_INICIAL_FIM);
$humor->setFinalTime(HUMOR_FINAL_INI, HUMOR_FINAL_FIM);
 
?>