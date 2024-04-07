<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

use DeepCode\api\SubmissionsController;
use DeepCode\controllers\HomeController;
use DeepCode\controllers\ProblemsController;
use DeepCode\controllers\ProfileController;
use DeepCode\db\DeepCodeContext;
use Framework\application\App;
use Framework\mapper\RouteMapper;

try{

    // Create app and configure all services.
    $app = new App();
    $app->services->addSingleton( DeepCodeContext::class,
        new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"));

    // Initialize controllers using automapper. Automapper will map each controller by some route.
    $automapper = new RouteMapper($app->router, $app->services);
//    $automapper->mapControllers("", "src/controllers");
//    $automapper->mapControllers("api/", "api");

    $automapper->mapController("", HomeController::class);
    $automapper->mapController("", ProblemsController::class);
    $automapper->mapController("", ProfileController::class);
    $automapper->mapController("/api", SubmissionsController::class);

//    $app->router->dump_routes();

    // redirect using router.
    $app->router->redirect($_SERVER['REQUEST_URI']);

}catch(Exception $e){
    if(empty($GLOBALS['IS_DEBUG'])){
        echo "Internal server error.";
    }
    else{
        var_dump($e);
    }
}
