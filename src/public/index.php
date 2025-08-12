<?php

declare(strict_types=1);

use App\Core\Container;
use App\Core\Router;
use App\Core\App;
use App\Presentation\Controllers\UserController;

session_start();

require __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../app/Presentation/Views');

$container = new Container();
$router = new Router($container);

$router->registerRoutesFromControllerAttributes(
    [
        UserController::class
    ]
);

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->boot()->run();
