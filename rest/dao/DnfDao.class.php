<?php

class DnfDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM dnf");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($challenges_id){
        $stmt= $this->conn->prepare("SELECT * FROM dnf WHERE dnf_id=:dnf_id");
        $stmt->bindParam(':dnf_id', $dnf_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($dnf){
        $stmt= $this->conn->prepare("INSERT INTO dnf(b_name, b_author, b_title, b_published, dnf_date) VALUES(:b_name, :b_author, :b_title, :b_published, :dnf_date)");
        $stmt->bindParam(':b_name', $b_name);
        $stmt->bindParam(':b_author', $b_author);
        $stmt->bindParam(':b_title', $b_title);
        $stmt->bindParam(':b_published', $b_published);
        $stmt->bindParam(':dnf_date', $dnf_date);
        $stmt->execute($dnf);
        $dnf['dnf_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $dnf;

    }

    public function delete($dnf_id){
        $stmt= $this->conn->prepare("DELETE FROM dnf WHERE dnf_id=:dnf_id");
        $stmt->bindParam(':dnf_id', $dnf_id);
        $stmt->execute();
    }

    public function update($dnf){   //update by id
        $stmt= $this->conn->prepare("UPDATE dnf SET :img, :quotes WHERE dnf_id=:dnf_id");
        $stmt->bindParam(':dnf_id', $dnf_id);
        $stmt->bindParam(':b_name', $b_name);
        $stmt->bindParam(':b_author', $b_author);
        $stmt->bindParam(':b_title', $b_title);
        $stmt->bindParam(':b_published', $b_published);
        $stmt->bindParam(':dnf_date', $dnf_date);
        $stmt->execute($dnf);
    }
}
?>