<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /reviews', function(){
  Flight::json(Flight::reviewService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /reviews/@id', function($id){
  Flight::json(Flight::reviewService()->get_by_id($id));
});

/**
* add review
*/
Flight::route('POST /reviews', function(){
  Flight::json(Flight::reviewService()->add(Flight::request()->data->getData()));
});

/**
* update review
*/
Flight::route('PUT /reviews/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::reviewService()->update($id, $data));
});

/**
* delete review
*/
Flight::route('DELETE /reviews/@id', function($id){
  Flight::reviewService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>