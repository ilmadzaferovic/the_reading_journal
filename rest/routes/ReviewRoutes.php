<?php

/**
 * @OA\Get(path="/reviews", tags={"reviews"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all reviews from the API. ",
 *         @OA\Response( response=200, description="List of reviews.")
 * )
 */
Flight::route('GET /reviews', function(){
  Flight::json(Flight::reviewService()->get_all());
});

/**
  * @OA\Get(path="/reviews/{id}", tags={"reviews"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Reviews ID"),
  *     @OA\Response(response="200", description="Fetch individual reviews")
  * )
  */
Flight::route('GET /reviews/@id', function($id){
  Flight::json(Flight::reviewService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/reviews", security={{"ApiKeyAuth": {}}},
*     description="Add a review",
*     tags={"reviews"},
*     @OA\RequestBody(description="Add a new review", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="characters", type="string", example="Harry and Ron",	description="Book characters"),
*    				@OA\Property(property="moments", type="string", example="When they played quidditch",	description="Favourite book moments" ),
*           @OA\Property(property="plot", type="string", example="Harry saving wizarding world",	description="Book plot summary" ),
*           @OA\Property(property="rating", type="string", example="10/10",	description="Book rating" ),
*           @OA\Property(property="read_date", type="date", example="1/1/2020",	description="Book finish date" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Review has been added"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /reviews', function(){
  Flight::json(Flight::reviewService()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Put(
 *     path="/reviews/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Edit a reviews",
 *     tags={"reviews"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Reviews ID"),
 *     @OA\Parameter(in="path", name="data", example=1, description="Data"),
 *     @OA\RequestBody(description="Reviews info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    			@OA\Property(property="characters", type="string", example="Harry and Ron",	description="Book characters"),
*    				@OA\Property(property="moments", type="string", example="When they played quidditch",	description="Favourite book moments" ),
*           @OA\Property(property="plot", type="string", example="Harry saving wizarding world",	description="Book plot summary" ),
*           @OA\Property(property="rating", type="string", example="10/10",	description="Book rating" ),
*           @OA\Property(property="read_date", type="date", example="1/1/2020",	description="Book finish date" ),
 *        )
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="Review has been edited"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('PUT /reviews/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::reviewService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/reviews/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Delete a review",
 *     tags={"reviews"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Reviews ID"),
 *     @OA\Response(
 *         response=200,
 *         description="Review has been deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('DELETE /reviews/@id', function($id){
  Flight::reviewService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

?>