<?php
// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /book', function(){
  Flight::json(Flight::bookService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /book/@id', function($id){
  Flight::json(Flight::bookService()->get_by_id($id));
});

/**
* add book
*/
Flight::route('POST /book', function(){
  Flight::json(Flight::bookService()->add(Flight::request()->data->getData()));
});

/**
* update book
*/
Flight::route('PUT /book/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::bookService()->update($id, $data));
});

/**
* delete book
*/
Flight::route('DELETE /book/@id', function($id){
  Flight::bookService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

Flight::route('GET /book/@id/reviews', function($id){
  Flight::json(Flight::reviewService()->get_review_by_id($id));
});

?>