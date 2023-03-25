<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /dnf', function(){
  Flight::json(Flight::dnfService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /dnf/@id', function($id){
  Flight::json(Flight::dnfService()->get_by_id($id));
});

/**
* add dnf
*/
Flight::route('POST /dnf', function(){
  Flight::json(Flight::dnfService()->add(Flight::request()->data->getData()));
});

/**
* update dnf
*/
Flight::route('PUT /dnf/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::dnfService()->update($id, $data));
});

/**
* delete dnf
*/
Flight::route('DELETE /dnf/@id', function($id){
  Flight::dnfService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>