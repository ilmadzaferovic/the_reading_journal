<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /challenges', function(){
  Flight::json(Flight::challengeService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /challenges/@id', function($id){
  Flight::json(Flight::challengeService()->get_by_id($id));
});

/**
* add challenges
*/
Flight::route('POST /challenges', function(){
  Flight::json(Flight::challengeService()->add(Flight::request()->data->getData()));
});

/**
* update challenges
*/
Flight::route('PUT /challenges/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::challengeService()->update($id, $data));
});

/**
* delete challenges
*/
Flight::route('DELETE /challenges/@id', function($id){
  Flight::challengeService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>