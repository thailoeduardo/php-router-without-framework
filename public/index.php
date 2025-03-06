<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;

$router = new Router();

// Define routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/users', [UserController::class, 'index']);
$router->get('/user/{id}', [UserController::class, 'show']);


// Handle the current request
echo $router->resolve();