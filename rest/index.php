<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/services/BookService.class.php';
require_once __DIR__.'/services/ChallengeService.class.php';
require_once __DIR__.'/services/DnfService.class.php';
require_once __DIR__.'/services/ReviewService.class.php';
require_once __DIR__.'/dao/UserDao.class.php';

Flight::register('bookService', 'BookService');
Flight::register('challengeService', 'ChallengeService');
Flight::register('dnfService', 'DnfService');
Flight::register('reviewService', 'ReviewService');
Flight::register('userDao', 'UserDao');

Flight::map('error', function(Exception $ex){
    // Handle error
    Flight::json(['message' => $ex->getMessage()], 500);
});

Flight::route('/*', function(){
    //perform JWT decode
    $path = Flight::request()->url;
    if ($path == '/login') return TRUE; //exclude login route from middleware
    if ($path == '/register') return TRUE; // exclude register route from middleware
    if ($path == '/docs.json') return TRUE;

    $headers = getallheaders();
    if (@!$headers['Authorization']){
      Flight::json(["message" => "Authorization is missing"], 403);
      return FALSE;
    }else{
      try {
        $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded);
        return TRUE;
      } catch (\Exception $e) {
        Flight::json(["message" => "Authorization token is not valid"], 403);
        return FALSE;
      }
    }
  });

  /* REST API documentation endpoint */
Flight::route('GET /docs.json', function(){
  $openapi = \OpenApi\scan('routes');
  header('Content-Type: application/json');
  echo $openapi->toJson();
});


require_once __DIR__.'/routes/BookRoutes.php';
require_once __DIR__.'/routes/ChallengeRoutes.php';
require_once __DIR__.'/routes/DnfRoutes.php';
require_once __DIR__.'/routes/ReviewRoutes.php';
require_once __DIR__.'/routes/UserRoutes.php';


Flight::start();
?>