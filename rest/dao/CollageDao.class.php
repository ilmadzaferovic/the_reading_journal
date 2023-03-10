<?php

class CollageDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM collage");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($collage_id){
        $stmt= $this->conn->prepare("SELECT * FROM collage WHERE collage_id=:collage_id");
        $stmt->bindParam(':collage_id', $collage_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($collage){
        $stmt= $this->conn->prepare("INSERT INTO collage(img, quotes) VALUES(:img, :quotes)");
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':quotes', $quotes);
        $stmt->execute($collage);
        $collage['collage_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $collage;

    }

    public function delete($collage_id){
        $stmt= $this->conn->prepare("DELETE FROM collage WHERE collage_id=:collage_id");
        $stmt->bindParam(':collage_id', $collage_id);
        $stmt->execute();
    }

    public function update($collage){   //update by id
        $stmt= $this->conn->prepare("UPDATE collage SET :img, :quotes WHERE collage_id=:collage_id");
        $stmt->bindParam(':collage_id', $collage_id);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':quotes', $quotes);
        $stmt->execute($collage);
    }
}
?>