<?php

require_once "vendor/autoload.php";

$GLOBALS['IS_DEBUG'] = true;

use DeepCode\controllers as Controllers;
use DeepCode\server\Server;
use DeepCode\db\DeepCodeContext;

// Core of the project

// configure all services, create router and start redirection

if(Server::isInitialized() === false){
    // initialize

    $server = Server::getInstance();

    $server->deepCodeContext = new DeepCodeContext("mysql:host=127.0.0.1;dbname=deep_code");

    $server->router->addRoute("/", function() {
        $controller = new Controllers\HomeController();

        $controller->Index();
    });

    $server->router->addRoute("/problems", function() use ($server) {
        $controller = new Controllers\ProblemsController($server->deepCodeContext);

        $controller->Index();
    });
    $server->router->addRoute("/problem", function() use ($server) {
        $controller = new Controllers\ProblemsController($server->deepCodeContext);

        $controller->GetProblem(1);
    });

    $server->router->addRoute("/profile", function() use($server) {
        $controller = new Controllers\ProfileController($server->deepCodeContext);

        $controller->Index();
    });
}

$server = Server::getInstance();

try{
    $server->router->handleRoute($_SERVER['REQUEST_URI']);
}catch(Exception $e){
    if($GLOBALS['IS_DEBUG']){
        var_dump($e);
    }
    else{
        echo "Not founded.";
    }
}
