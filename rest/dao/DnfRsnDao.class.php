<?php

class DnfRsnDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM dnf_reasons");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($dnf_reasons){
        $stmt= $this->conn->prepare("SELECT * FROM dnf_reasons WHERE dnf_reasons_id=:dnf_reasons_id");
        $stmt->bindParam(':dnf_reasons_id', $dnf_reasons_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($dnf_reasons){
        $stmt= $this->conn->prepare("INSERT INTO dnf_reasons(description) VALUES(:description)");
        $stmt->bindParam(':description', $description);
        $stmt->execute($dnf_reasons);
        $dnf_reasons['dnf_reasons_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $dnf_reasons;

    }

    public function delete($dnf_reasons_id){
        $stmt= $this->conn->prepare("DELETE FROM dnf_reasons WHERE dnf_reasons_id=:dnf_reasons_id");
        $stmt->bindParam(':dnf_reasons_id', $dnf_reasons_id);
        $stmt->execute();
    }

    public function update($dnf_reasons){   //update by id
        $stmt= $this->conn->prepare("UPDATE dnf_reasons SET :description WHERE dnf_reasons_id=:dnf_reasons_id");
        $stmt->bindParam(':description', $description);
        $stmt->execute($dnf_reasons);
    }
}
?>