<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /challenges', function(){
  Flight::json(Flight::challengeRoutes()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /challenges/@id', function($id){
  Flight::json(Flight::challengeRoutes()->get_by_id($id));
});

/**
* add challenges
*/
Flight::route('POST /challenges', function(){
  Flight::json(Flight::challengeRoutes()->add(Flight::request()->data->getData()));
});

/**
* update challenges
*/
Flight::route('PUT /challenges/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::challengeRoutes()->update($id, $data));
});

/**
* delete challenges
*/
Flight::route('DELETE /challenges/@id', function($id){
  Flight::challengeRoutes()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>