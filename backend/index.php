<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

if($GLOBALS['IS_DEBUG']){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
}

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
    $automapper->mapControllers("", "./src/controllers");
    $automapper->mapControllers("/api", "./src/api");

    // index.php don't even know about controllers, and create controller when it required.

    // redirect using router.
    $app->router->redirect($_SERVER['REQUEST_URI']);

}catch(Exception $e){
    if(empty($GLOBALS['IS_DEBUG'])){
        echo "Internal server error.";
    }
    else{
        echo json_encode($e->getMessage());
    }
}
