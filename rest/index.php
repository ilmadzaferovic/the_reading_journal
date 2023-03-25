<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/services/BookService.class.php';
require_once __DIR__.'/services/ChallengeService.class.php';
require_once __DIR__.'/services/CollageService.class.php';
require_once __DIR__.'/services/DnfRsnService.class.php';
require_once __DIR__.'/services/DnfService.class.php';
require_once __DIR__.'/services/ReviewService.class.php';
require_once __DIR__.'/services/UserService.class.php';

Flight::register('bookService', 'BookService');
Flight::register('challengeService', 'ChallengeService');
Flight::register('collageService', 'CollageService');
Flight::register('dnfrsnService', 'DnfRsnService');
Flight::register('dnfService', 'DnfService');
Flight::register('reviewService', 'ReviewService');
Flight::register('userService', 'UserService');

require_once __DIR__.'/routes/BookRoutes.php';
require_once __DIR__.'/routes/ChallengeRoutes.php';
require_once __DIR__.'/routes/CollageRoutes.php';
require_once __DIR__.'/routes/DnfRoutes.php';
require_once __DIR__.'/routes/DnfRsnRoutes.php';
require_once __DIR__.'/routes/ReviewRoutes.php';
require_once __DIR__.'/routes/UserRoutes.php';

Flight::start();
?>