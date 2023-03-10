<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once 'dao/BookDao.class.php';

Flight::register('bookDao', 'BookDao');  //$dao= new TodoDao();

Flight::route('GET /book', function(){
    $result= Flight::bookDao()->get_all();
    Flight::json($result);
});

Flight::route('GET /book/@book_id', function($book_id){
    $result= Flight::bookDao()->get_one($book_id);
    Flight::json($result);
});

Flight::route('POST /book', function(){
    $request = Flight::request();
    $data=$request->data->getData();
    $todo=Flight::bookDao()->add($data);
    Flight::json($todo); //prints the inserted out
});

Flight::route('PUT /book/@id', function($book_id){
    $request = Flight::request();
    $data=$request->data->getData();
    $data['book_id']=$book_id;
    Flight::bookDao()->update($data);
    Flight::json($data); 
});

Flight::route('DELETE /book/@book_id', function($book_id){
    Flight::bookDao()->delete($book_id);
    Flight::json(["deleted $book_id"]);
});


Flight::start();
?>