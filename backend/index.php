<?php

require_once "vendor/autoload.php";

use DeepCode\DB\DeepCodeContext;
use DeepCode\Middlewares\JWTAuthenticationMiddleware;
use DeepCode\Repositories\Implementation\ProblemsRepository;
use DeepCode\Repositories\Interfaces\IProblemsRepository;
use Framework\Application\AppBuilder;
use Framework\Http\HttpContext;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Controllers\ControllerMiddleware;
use Framework\Middlewares\Cors\CORS;
use Framework\Middlewares\Development\ErrorCatcher;
use Framework\Middlewares\Routing\Router;
use Framework\MVC\Views\ViewRenderer;

// Create app and configure all services.
$appBuilder = new AppBuilder();

// basic service configuration
$appBuilder->services()
    ->addScoped(HttpContext::class)
    ->addScoped(Router::class)
    ->addScoped(RouteMapper::class);

// database
$appBuilder->services()
    ->addScoped(DeepCodeContext::class,
        fn() => new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"));

// repositories
$appBuilder->services()
    ->addScopedForInterface(IProblemsRepository::class, ProblemsRepository::class);


$appBuilder
    ->use(ErrorCatcher::class) // for debugging
    ->use(CORS::class)

    // use default authorization middleware
    ->use(JWTAuthenticationMiddleware::class);

$appBuilder->use(function($next){
        if(str_starts_with($_SERVER['REQUEST_URI'], "/api"))
            header('Content-Type: application/json; charset=utf-8');
        $next();
    });

// Initialize controllers using automapper. Automapper will map each controller by some route.
$appBuilder->services()->invokeFunction(function (RouteMapper $automapper) {
        // maps and redirect to the specific resource.
        $automapper->mapControllers("", "./src/Controllers");
        $automapper->mapControllers("/api", "./src/Api");
    });


// to invoke controller action
$appBuilder->use(ControllerMiddleware::class);

// index.php don't even know about controllers, application will create controller when needed.
$app = $appBuilder->build();

$app->handleRequest();

