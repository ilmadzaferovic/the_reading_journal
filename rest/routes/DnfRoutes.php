<?php

/**
 * @OA\Get(path="/dnf", tags={"dnf"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all dnfs from the API. ",
 *         @OA\Response( response=200, description="List of dnfs.")
 * )
 */
Flight::route('GET /dnf', function(){
  Flight::json(Flight::dnfService()->get_all());
});

/**
  * @OA\Get(path="/dnf/{id}", tags={"dnf"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Dnf ID"),
  *     @OA\Response(response="200", description="Fetch individual dnfs")
  * )
  */
Flight::route('GET /dnf/@id', function($id){
  Flight::json(Flight::dnfService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/dnf", security={{"ApiKeyAuth": {}}},
*     description="Add a dnf",
*     tags={"dnf"},
*     @OA\RequestBody(description="Add a new dnf", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="b_title", type="string", example="Anna Karenina",	description="Book title"),
*    				@OA\Property(property="b_author", type="string", example=" Lev Nikolayevich Tolstoy",	description="Author name" ),
*           @OA\Property(property="b_published", type="date", example="1878",	description="Year book was published" ),
*           @OA\Property(property="b_genre", type="string", example="drama",	description="Book genre" ),
*           @OA\Property(property="dcover", type="longtext", example="",	description="Book cover" ),
*           @OA\Property(property="dnf_date", type="date", example="the day you dnf-ed the book",	description="Dnf date" ),
*           @OA\Property(property="reason", type="string", example="reason you dnf-ed a book",	description="Dnf reason" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Dnf has been added"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /dnf', function(){
  Flight::json(Flight::dnfService()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Put(
 *     path="/dnf/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Edit a dnf",
 *     tags={"dnf"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Dnf ID"),
 *     @OA\Parameter(in="path", name="data", example=1, description="Data"),
 *     @OA\RequestBody(description="Dnf info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="b_title", type="string", example="Anna Karenina",	description="Book title"),
*    				@OA\Property(property="b_author", type="string", example=" Lev Nikolayevich Tolstoy",	description="Author name" ),
*           @OA\Property(property="b_published", type="date", example="1/1/1878",	description="Year book was published" ),
*           @OA\Property(property="b_genre", type="string", example="drama",	description="Book genre" ),
*           @OA\Property(property="dcover", type="longtext", example="",	description="Book cover" ),
*           @OA\Property(property="dnf_date", type="date", example="1/2/2023",	description="Dnf date" ),
*           @OA\Property(property="reason", type="string", example="very boring",	description="Dnf reason" ),
 *        )
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="Dnf has been edited"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('PUT /dnf/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::dnfService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/dnf/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Delete a dnf",
 *     tags={"dnf"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Dnf ID"),
 *     @OA\Response(
 *         response=200,
 *         description="Dnf has been deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('DELETE /dnf/@id', function($id){
  Flight::dnfService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>