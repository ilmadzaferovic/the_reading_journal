<?php

/**
 * @OA\Get(path="/challenges", tags={"challenges"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all challenges from the API. ",
 *         @OA\Response( response=200, description="List of challenges.")
 * )
 */
Flight::route('GET /challenges', function(){
  Flight::json(Flight::challengeService()->get_all());
});

/**
  * @OA\Get(path="/challenges/{id}", tags={"challenges"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Challenge ID"),
  *     @OA\Response(response="200", description="Fetch individual challenges")
  * )
  */
Flight::route('GET /challenges/@id', function($id){
  Flight::json(Flight::challengeService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/challenges", security={{"ApiKeyAuth": {}}},
*     description="Add a challenge",
*     tags={"challenges"},
*     @OA\RequestBody(description="Add a new challenge", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="description", type="string", example="Read 50 pages in one day",	description="Reading challenge desc"),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Challenge has been added"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /challenges', function(){
  Flight::json(Flight::challengeService()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Put(
 *     path="/challenges/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Edit a challenge",
 *     tags={"challenges"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Challenge ID"),
 *     @OA\Parameter(in="path", name="data", example=1, description="Data"),
 *     @OA\RequestBody(description="Challenge info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="description", type="string", example="Read 50 pages in one day",	description="Reading challenge desc"),
 *        )
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="Challenge has been edited"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('PUT /challenges/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::challengeService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/challenges/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Delete a challenge",
 *     tags={"challenges"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Challenge ID"),
 *     @OA\Response(
 *         response=200,
 *         description="Challenge has been deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('DELETE /challenges/@id', function($id){
  Flight::challengeService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

Flight::route('GET /user/@id/challenge', function($id){
  Flight::json(Flight::challengeService()->get_challenge_by_user($id));
});


?>