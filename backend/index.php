<?php

require_once "vendor/autoload.php";

use DeepCode\DB\DeepCodeContext;
use DeepCode\Middlewares\JWTAuthenticationMiddleware;
use DeepCode\Repositories\IProblemsRepository;
use DeepCode\Repositories\ProblemsRepository;
use Framework\Application\AppBuilder;
use Framework\Mapper\RouteMapper;
use Framework\middlewares\Development\ErrorMiddleware;

// Create app and configure all services.
$appBuilder = new AppBuilder();

$appBuilder->useMiddleware(ErrorMiddleware::class);
$appBuilder->useMVC();
$appBuilder->useCors();

// add database
$appBuilder->services()
    ->addScoped(DeepCodeContext::class,
        fn() => new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"))
    ->addScoped(RouteMapper::class)
    ->addScopedForInterface(IProblemsRepository::class, ProblemsRepository::class);

// use default authorization middleware
$appBuilder->useMiddleware(JWTAuthenticationMiddleware::class);

// Initialize controllers using automapper. Automapper will map each controller by some route.
$appBuilder->use(
function(RouteMapper $automapper, $next) {
    $automapper->mapControllers("", "./src/Controllers");
    $automapper->mapControllers("/api", "./src/Api");
    $next();
});

$appBuilder->use(
    function($next){
        if(str_starts_with($_SERVER['REQUEST_URI'], "/api"))
            header('Content-Type: application/json; charset=utf-8');
        $next();
    }
);

// index.php don't even know about controllers, application will create controller when needed.
$app = $appBuilder->build();

$app->handleRequest();

