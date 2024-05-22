<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

use DeepCode\db\DeepCodeContext;
use DeepCode\middlewares\JWTAuthenticationMiddleware;
use DeepCode\Repositories\IProblemsRepository;
use DeepCode\Repositories\ProblemsRepository;
use Framework\application\AppBuilder;
use Framework\mapper\RouteMapper;

try{
    // Create app and configure all services.
    $appBuilder = new AppBuilder();

    $appBuilder->useMVC();
    $appBuilder->useCors();

    // add database
    $appBuilder->services()
        ->addSingleton( DeepCodeContext::class,
        new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"))
        ->addScoped(RouteMapper::class, RouteMapper::class)
        ->addScoped(IProblemsRepository::class, ProblemsRepository::class);

    // use default authorization middleware
    $appBuilder->useMiddleware(JWTAuthenticationMiddleware::class);

    // Initialize controllers using automapper. Automapper will map each controller by some route.
    $appBuilder->use(
    function(RouteMapper $automapper, $next) {
        $automapper->mapControllers("", "./src/controllers");
        $automapper->mapControllers("/api", "./src/api");
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

    $app->run();

}catch(Exception $e){
    if(empty($GLOBALS['IS_DEBUG'])){
        echo "Internal server error.";
    }
    else{
        var_dump($e);
//        echo json_encode($e->getMessage());
    }
}
