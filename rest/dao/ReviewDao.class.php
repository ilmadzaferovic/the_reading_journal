<?php

class ReviewDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM reviews");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($reviews_id){
        $stmt= $this->conn->prepare("SELECT * FROM reviews WHERE reviews_id=:reviews_id");
        $stmt->bindParam(':reviews_id', $review_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($reviews){
        $stmt= $this->conn->prepare("INSERT INTO reviews(characters, moments, plot, rating, read_date) VALUES(:characters, :moments, :plot, :rating, :read_date)");
        $stmt->bindParam(':cover', $cover);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':published', $published);
        $stmt->bindParam(':genre', $genre);
        $stmt->execute($reviews);
        $reviews['reviews_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $reviews;

    }

    public function delete($reviews_id){
        $stmt= $this->conn->prepare("DELETE FROM reviews WHERE reviews_id=:reviews_id");
        $stmt->bindParam(':reviews_id', $reviews_id);
        $stmt->execute();
    }

    public function update($reviews){   //update by id
        $stmt= $this->conn->prepare("UPDATE reviews SET :characters, :moments, :plot, :rating, :read_date WHERE reviews_id=:reviews_id");
        $stmt->bindParam(':reviews_id', $reviews_id);
        $stmt->bindParam(':cover', $cover);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':published', $published);
        $stmt->bindParam(':genre', $genre);
        $stmt->execute($reviews);
    }
}
?>