<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /dnf_reasons', function(){
  Flight::json(Flight::dnfrsnService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /dnf_reasons/@id', function($id){
  Flight::json(Flight::dnfrsnService()->get_by_id($id));
});

/**
* add dnf_reasons
*/
Flight::route('POST /dnf_reasons', function(){
  Flight::json(Flight::dnfrsnService()->add(Flight::request()->data->getData()));
});

/**
* update dnf_reasons
*/
Flight::route('PUT /dnf_reasons/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::dnfrsnService()->update($id, $data));
});

/**
* delete dnf_reasons
*/
Flight::route('DELETE /dnf_reasons/@id', function($id){
  Flight::dnfrsnService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>