<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /user', function(){
  Flight::json(Flight::userService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /user/@id', function($id){
  Flight::json(Flight::userService()->get_by_id($id));
});

/**
* add user
*/
Flight::route('POST /user', function(){
  Flight::json(Flight::userService()->add(Flight::request()->data->getData()));
});

/**
* update user
*/
Flight::route('PUT /user/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id, $data));
});

/**
* delete user
*/
Flight::route('DELETE /user/@id', function($id){
  Flight::userService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>