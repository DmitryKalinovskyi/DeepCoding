<?php

require_once "vendor/autoload.php";

use DeepCode\DB\DeepCodeContext;
use DeepCode\Middlewares\JWTAuthenticationMiddleware;
use DeepCode\Repositories\IProblemsRepository;
use DeepCode\Repositories\ProblemsRepository;
use Framework\Application\AppBuilder;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Cors\CORS;
use Framework\Middlewares\Development\ErrorCatcher;
use Framework\Middlewares\MVC\MVC;
use Framework\Middlewares\Routing\ControllerRouter;

// Create app and configure all services.
$appBuilder = new AppBuilder();

$appBuilder
    ->use(ErrorCatcher::class) // for debugging
    ->use(CORS::class)
    ->use(MVC::class);

$appBuilder->services()
    ->addScoped(DeepCodeContext::class,
        fn() => new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"))

    ->addScoped(RouteMapper::class)
    ->addScopedForInterface(IProblemsRepository::class, ProblemsRepository::class);

// use default authorization middleware
$appBuilder->use(JWTAuthenticationMiddleware::class);

$appBuilder->use(
    function($next){
        if(str_starts_with($_SERVER['REQUEST_URI'], "/api"))
            header('Content-Type: application/json; charset=utf-8');
        $next();
    }
);

// Initialize controllers using automapper. Automapper will map each controller by some route.
$appBuilder->use(
function(RouteMapper $automapper, $next) {
    $automapper->mapControllers("", "./src/Controllers");
    $automapper->mapControllers("/api", "./src/Api");
    $next();
});

$appBuilder->use(
    function(ControllerRouter $router){
        $router->redirect($_SERVER['REQUEST_URI']);
    }
);

// index.php don't even know about controllers, application will create controller when needed.
$app = $appBuilder->build();

$app->handleRequest();

