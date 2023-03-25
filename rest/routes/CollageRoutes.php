<?php

// CRUD operations for todos entity

/**
* List all todos
*/
Flight::route('GET /collage', function(){
  Flight::json(Flight::collageService()->get_all());
});

/**
* List invidiual note
*/
Flight::route('GET /collage/@id', function($id){
  Flight::json(Flight::collageService()->get_by_id($id));
});

/**
* add collage
*/
Flight::route('POST /collage', function(){
  Flight::json(Flight::collageService()->add(Flight::request()->data->getData()));
});

/**
* update collage
*/
Flight::route('PUT /collage/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::collageService()->update($id, $data));
});

/**
* delete collage
*/
Flight::route('DELETE /collage/@id', function($id){
  Flight::collageService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>