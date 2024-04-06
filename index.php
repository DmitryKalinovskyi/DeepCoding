<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

use DeepCode\db\DeepCodeContext;
use Framework\application\App;
use Framework\mapper\RouteMapper;

// Create app and configure all services.
$app = new App();
$app->services->AddSingleton(
    new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code"));

// Initialize controllers using automapper. Automapper will map each controller by some route.
$automapper = new RouteMapper($app->router, $app->services);
$automapper->mapControllers("", "src/controllers");
$automapper->mapControllers("api/", "api");



//$server->router->get->addRoute("/", function() use ($server){
//    $controller = $server->services->InjectServices(Controllers\HomeController::class, );
//    $controller = new Controllers\HomeController();
//
//    $controller->Index();
//});
//
//$server->router->get->addRoute("/problems", function() use ($server) {
//    $controller = new Controllers\ProblemsController($server->deepCodeContext);
//
//    $controller->Index();
//});
//$server->router->get->addRoute("/problem", function() use ($server) {
//    $controller = new Controllers\ProblemsController($server->deepCodeContext);
//
//    $controller->GetProblem();
//});
//
//$server->router->post->addRoute("/problem", function() use ($server) {
//    $controller = new Controllers\ProblemsController($server->deepCodeContext);
//
//    $controller->SubmitProblem();
//});
//
//$server->router->get->addRoute("/profile", function() use($server) {
//    $controller = new Controllers\ProfileController($server->deepCodeContext);
//
//    $controller->Index();
//});


//// api routes
//$server->router->get->addRoute("/api/problem/submissions", function() use($server) {
//    $controller = new SubmissionsController($server->deepCodeContext);
//
//    $controller->GetSubmissions();
//});
//
//$server->router->get->addRoute("/api/problem/submission", function() use($server) {
//    $controller = new SubmissionsController($server->deepCodeContext);
//
//    $controller->GetSubmission();
//});


try{
    $app->router->redirect($_SERVER['REQUEST_URI']);
}catch(Exception $e){
    if(empty($GLOBALS['IS_DEBUG'])){
        echo "Internal server error.";
    }
    else{
        var_dump($e);
    }
}
