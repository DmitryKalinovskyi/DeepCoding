<?php

require_once "vendor/autoload.php";

use DeepCode\DB\DBSeeder;
use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\Authentication\Middlewares\JWTAuthenticationMiddleware;
use DeepCode\Modules\Authentication\Repositories\IRolesRepository;
use DeepCode\Modules\Authentication\Repositories\IUser_RolesRepository;
use DeepCode\Modules\Authentication\Repositories\RolesRepository;
use DeepCode\Modules\Authentication\Repositories\User_RolesRepository;
use DeepCode\Modules\Authentication\Services\IJWTService;
use DeepCode\Modules\Authentication\Services\JWTService;
use DeepCode\Modules\Problems\Repositories\Implementation\ProblemsRepository;
use DeepCode\Modules\Problems\Repositories\Implementation\SubmissionsRepository;
use DeepCode\Modules\Problems\Repositories\Interfaces\IProblemsRepository;
use DeepCode\Modules\Problems\Repositories\Interfaces\ISubmissionsRepository;
use DeepCode\Modules\Users\Repositories\UserRepository;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Application\AppBuilder;
use Framework\Application\Configurations\MVCConfiguration;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Controllers\ControllerMiddleware;
use Framework\Middlewares\Cors\CORS;
use Framework\Middlewares\Development\ErrorCatcher;
use Framework\Middlewares\Routing\Router;
use Framework\Services\IPasswordHashingService;
use Framework\Services\PasswordHashingService;

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create app and configure all services.
$appBuilder = new AppBuilder();

$appBuilder->useConfiguration(MVCConfiguration::class);

// basic service configuration
$appBuilder->services()
    ->addTransientForInterface(IJWTService::class, JWTService::class)
    ->addTransientForInterface(IPasswordHashingService::class, PasswordHashingService::class);

// database
$appBuilder->services()
    ->addScoped(DeepCodeContext::class,
        fn() => new DeepCodeContext($_ENV['DB_MYSQL']));

// repositories
$appBuilder->services()
    ->addScopedForInterface(IProblemsRepository::class, ProblemsRepository::class)
    ->addScopedForInterface(IUserRepository::class, UserRepository::class)
    ->addScopedForInterface(ISubmissionsRepository::class, SubmissionsRepository::class)
    ->addScopedForInterface(IRolesRepository::class, RolesRepository::class)
    ->addScopedForInterface(IUser_RolesRepository::class, User_RolesRepository::class);

// configure middleware pipeline
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

// to invoke controller action
$appBuilder->use(ControllerMiddleware::class);

// Initialize controllers using automapper. Automapper will map each controller by some route.
$appBuilder->services()->invokeFunction(function(RouteMapper $routeMapper){
    $routeMapper->mapControllers("/api", "./src/Modules/Users/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Authentication/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Problems/Controllers");
});

$appBuilder->services()->invokeFunction(function (Router $router) {
//    $router->dump_routes();
});

// seed
$appBuilder->services()->addTransient(DBSeeder::class);
$appBuilder->services()->invokeFunction(fn(DBSeeder $seeder) => $seeder->seed());

// index.php don't even know about controllers, application will create controller when needed.
$app = $appBuilder->build();

$app->handleRequest();

