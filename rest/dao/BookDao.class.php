<?php

class BookDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM book");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($book_id){
        $stmt= $this->conn->prepare("SELECT * FROM book WHERE book_id=:book_id");
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($book){
        $stmt= $this->conn->prepare("INSERT INTO book(cover, title, author, published, genre) VALUES(:cover, :title, :author, :published, :genre)");
        $stmt->bindParam(':cover', $cover);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':published', $published);
        $stmt->bindParam(':genre', $genre);
        $stmt->execute($book);
        $book['book_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $book;

    }

    public function delete($book_id){
        $stmt= $this->conn->prepare("DELETE FROM book WHERE book_id=:book_id");
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
    }

    public function update($book){   //update by id
        $stmt= $this->conn->prepare("UPDATE book SET :cover, :title, :author, :published, :genre WHERE book_id=:book_id");
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':cover', $cover);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':published', $published);
        $stmt->bindParam(':genre', $genre);
        $stmt->execute($book);
    }
}
?>