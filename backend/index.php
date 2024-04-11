<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

use DeepCode\db\DeepCodeContext;
use Framework\application\App;
use Framework\application\AppBuilder;
use Framework\mapper\RouteMapper;
use Framework\middlewares\Authentication\JWTAuthenticationMiddleware;
use Framework\routing\Router;

try{
    // Create app and configure all services.
    $appBuilder = new AppBuilder();

    $appBuilder->useCors();

    // add database
    $appBuilder->services()
        ->addSingleton( DeepCodeContext::class,
        new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"))
        ->addScoped(RouteMapper::class, RouteMapper::class);

    $appBuilder->useRouter();

    // use default authorization middleware
    $appBuilder->useMiddleware(JWTAuthenticationMiddleware::class);

    // Initialize controllers using automapper. Automapper will map each controller by some route.
    $appBuilder->useMiddleware(
    function(RouteMapper $automapper) {
        $automapper->mapControllers("", "./src/controllers");
        $automapper->mapControllers("/api", "./src/api");
    });

    // index.php don't even know about controllers, application will create controller when needed.
    $app = $appBuilder->build();

    $app->run();

}catch(Exception $e){
    if(empty($GLOBALS['IS_DEBUG'])){
        echo "Internal server error.";
    }
    else{
        echo json_encode($e->getMessage());
    }
}
