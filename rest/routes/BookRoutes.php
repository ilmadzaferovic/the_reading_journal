<?php


/**
 * @OA\Get(path="/book", tags={"book"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all books from the API. ",
 *         @OA\Response( response=200, description="List of books.")
 * )
 */
Flight::route('GET /book', function(){
  Flight::json(Flight::bookService()->get_all());
});

Flight::route('GET /user/@id/book', function($id){
  Flight::json(Flight::bookService()->get_books_by_user($id));
});

/**
  * @OA\Get(path="/book/{id}", tags={"book"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Book ID"),
  *     @OA\Response(response="200", description="Fetch individual books")
  * )
  */
Flight::route('GET /book/@id', function($id){
  Flight::json(Flight::bookService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/book", security={{"ApiKeyAuth": {}}},
*     description="Add a book",
*     tags={"book"},
*     @OA\RequestBody(description="Add a new book", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="title", type="string", example="Anna Karenina",	description="Book title"),
*    				@OA\Property(property="author", type="string", example="Leo Tolstoy",	description="Author name" ),
*           @OA\Property(property="published", type="date", example="1878",	description="Year book was published" ),
*           @OA\Property(property="genre", type="string", example="drama",	description="Book genre" ),
*           @OA\Property(property="cover", type="longtext", example="",	description="Book cover" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Book has been added"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /book', function(){
  Flight::json(Flight::bookService()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Put(
 *     path="/book/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Edit a book",
 *     tags={"book"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Book ID"),
 *     @OA\Parameter(in="path", name="data", example=1, description="Data"),
 *     @OA\RequestBody(description="Book info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="title", type="string", example="Anna Karenina",	description="Book title"),
*    				@OA\Property(property="author", type="string", example=" Lev Nikolayevich Tolstoy",	description="Author name" ),
*           @OA\Property(property="published", type="date", example="1878",	description="Year book was published" ),
*           @OA\Property(property="genre", type="string", example="drama",	description="Book genre" ),
*           @OA\Property(property="cover", type="longtext", example="",	description="Book cover" ),
 *        )
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="Book has been edited"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('PUT /book/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::bookService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/book/{id}", security={{"ApiKeyAuth": {}}},
 *     description="Delete a book",
 *     tags={"book"},
 *     @OA\Parameter(in="path", name="id", example=1, description="Book ID"),
 *     @OA\Response(
 *         response=200,
 *         description="Book has been deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error"
 *     )
 * )
 */
Flight::route('DELETE /book/@id', function($id){
  Flight::bookService()->delete($id);
  Flight::json(["message" => "deleted"]);
});

/**
  * @OA\Get(path="/book/{id}/reviews", tags={"book, review"}, security={{"ApiKeyAuth": {}}},
  *     @OA\Parameter(in="path", name="id", example=1, description="Book ID"),
  *     @OA\Response(response="200", description="Fetch a review for each book")
  * )
  */
Flight::route('GET /book/@id/reviews', function($id){
  Flight::json(Flight::reviewService()->get_review_by_id($id));
});

?>