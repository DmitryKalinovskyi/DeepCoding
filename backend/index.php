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
use DeepCode\Modules\CodeRunner\CodeRunner\CodeRunner;
use DeepCode\Modules\Following\Repositories\FollowingRepository;
use DeepCode\Modules\Following\Repositories\IFollowingRepository;
use DeepCode\Modules\GroupedAPIRequests\Repositories\IUsersGroupedRepository;
use DeepCode\Modules\GroupedAPIRequests\Repositories\UsersGroupedRepository;
use DeepCode\Modules\News\Repositories\INewsRepository;
use DeepCode\Modules\News\Repositories\NewsRepository;
use DeepCode\Modules\Problems\Repositories\IProblemsRepository;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use DeepCode\Modules\Problems\Repositories\ProblemsRepository;
use DeepCode\Modules\Problems\Repositories\SubmissionsRepository;
use DeepCode\Modules\Reports\Repositories\IReportsRepository;
use DeepCode\Modules\Reports\Repositories\ReportsRepository;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use DeepCode\Modules\Users\Repositories\UserRepository;
use Framework\Application\AppBuilder;
use Framework\Application\Configurations\DefaultConfiguration;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Controllers\ControllerMiddleware;
use Framework\Middlewares\Cors\UNSAFE_CORS;
use Framework\Services\IPasswordHashingService;
use Framework\Services\PasswordHashingService;

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create app and configure all services.
$appBuilder = new AppBuilder();

$appBuilder->useConfigurationInstance(
    new DefaultConfiguration(isDevelopment: true));

// basic service configuration
$appBuilder->services()
    ->addTransientForInterface(IJWTService::class, JWTService::class)
    ->addTransientForInterface(IPasswordHashingService::class, PasswordHashingService::class);

// database
$appBuilder->services()
    ->addScoped(DeepCodeContext::class,
        fn() => new DeepCodeContext($_ENV['DB_MYSQL'], $_ENV['DB_MYSQL_NAME'], $_ENV['DB_MYSQL_PASSWORD']));

// repositories
$appBuilder->services()
    ->addScopedForInterface(IProblemsRepository::class, ProblemsRepository::class)
    ->addScopedForInterface(IUserRepository::class, UserRepository::class)
    ->addScopedForInterface(ISubmissionsRepository::class, SubmissionsRepository::class)
    ->addScopedForInterface(IRolesRepository::class, RolesRepository::class)
    ->addScopedForInterface(IUser_RolesRepository::class, User_RolesRepository::class)
    ->addScopedForInterface(INewsRepository::class, NewsRepository::class)
    ->addScopedForInterface(IReportsRepository::class, ReportsRepository::class)
    ->addScopedForInterface(IFollowingRepository::class, FollowingRepository::class)
    ->addScopedForInterface(IUsersGroupedRepository::class, UsersGroupedRepository::class)
    ->addScoped( CodeRunner::class);

// configure middleware pipeline
$appBuilder
    ->use(UNSAFE_CORS::class)

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
    $routeMapper->mapControllers("/api", "./src/Modules/News/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Scheme/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Reports/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/Following/Controllers");
    $routeMapper->mapControllers("/api/g", "./src/Modules/GroupedAPIRequests/Controllers");
    $routeMapper->mapControllers("/api", "./src/Modules/CodeRunner/Controllers");
});

// seed
$appBuilder->services()->addTransient(DBSeeder::class);
$appBuilder->services()->invokeFunction(fn(DBSeeder $seeder) => $seeder->seed());

// index.php don't even know about controllers, application will create controller when needed.
$app = $appBuilder->build();

$app->handleRequest();

