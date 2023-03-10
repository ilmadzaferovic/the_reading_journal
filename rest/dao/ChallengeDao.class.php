<?php

class ChallengeDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM challenges");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($challenges_id){
        $stmt= $this->conn->prepare("SELECT * FROM challenges WHERE challenges_id=:challenges_id");
        $stmt->bindParam(':challenges_id', $challenges_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($challenges){
        $stmt= $this->conn->prepare("INSERT INTO challenges(description, start_date, end_date) VALUES(:description, :start_date, :end_date)");
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute($challenges);
        $challenges['challenges_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $challenges;

    }

    public function delete($challenges_id){
        $stmt= $this->conn->prepare("DELETE FROM challenges WHERE challenges_id=:challenges_id");
        $stmt->bindParam(':challenges_id', $challenges_id);
        $stmt->execute();
    }

    public function update($challenges){   //update by id
        $stmt= $this->conn->prepare("UPDATE challenges SET :img, :quotes WHERE challenges_id=:challenges_id");
        $stmt->bindParam(':challenges_id', $challenges_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute($challenges);
    }
}
?>