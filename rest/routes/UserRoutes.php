<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



 /**
* @OA\Post(
*     path="/login", 
*     description="Login",
*     tags={"login"},
*     @OA\RequestBody(description="Login", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*             @OA\Property(property="email", type="string", example="ilmadz@gmail.com",	description="User email" ),
*             @OA\Property(property="password", type="string", example="12345",	description="Password" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Logged in successfuly"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
Flight::route('POST /login', function(){
    $login = Flight::request()->data->getData();
    $user = Flight::userDao()->get_user_by_email($login['email']);
    if (isset($user['id'])){
      if($user['password'] == md5($login['password'])){
        unset($user['password']);
        $jwt = JWT::encode($user, Config::JWT_SECRET(), 'HS256');
        $user['token'] = $jwt;
        Flight::json($user);
       
      }else{
        Flight::json(["message" => "Wrong password"], 404);
      }
    }else{
      Flight::json(["message" => "User doesn't exist"], 404);
    }
});

 /**
* @OA\Post(
*     path="/register", 
*     description="Register",
*     tags={"register"},
*     @OA\RequestBody(description="Register", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*             @OA\Property(property="email", type="string", example="ilma@gmail.com",	description="User email" ),
*             @OA\Property(property="password", type="string", example="12345",	description="Password" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Registered in successfuly"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/

Flight::route('POST /register', function(){
  
  $userDao = Flight::userDao();
  $registrationData = Flight::request()->data->getData();
  $registrationData['password'] = md5($registrationData['password']);
  Flight::json(Flight::userDao()->add($registrationData));
});


Flight::route('GET /user/@id', function($id){
  Flight::json(Flight::userDao()->get_by_id($id));
});

Flight::route('GET /user', function(){
  Flight::json(Flight::userDao()->get_all());
});

?>