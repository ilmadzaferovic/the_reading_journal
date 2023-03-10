<?php

class UserDao{

    private $conn;
    public function __construct(){
    $servername = "localhost";
    $username = "root";
    $password = "mysqlmysqlmysql123";
    
    $this->conn = new PDO("mysql:host=$servername;dbname=rj", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all(){
        $stmt= $this->conn->prepare("SELECT * FROM user");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function get_one($user_id){
        $stmt= $this->conn->prepare("SELECT * FROM user WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result);   //only get the element of an array not an array

    }

    public function add($user){
        $stmt= $this->conn->prepare("INSERT INTO user(name, l_name, email, password) VALUES(:name, :l_name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':l_name', $l_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute($user);
        $user['user_id']=$this->conn->lastInsertId(); //to get the id of last inserted data
        return $user;

    }

    public function delete($user_id){
        $stmt= $this->conn->prepare("DELETE FROM user WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    public function update($user){   //update by id
        $stmt= $this->conn->prepare("UPDATE user SET :name, :l_name, :email, :password WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':l_name', $l_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute($user);
    }
}
?>