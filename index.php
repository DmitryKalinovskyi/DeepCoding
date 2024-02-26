<?php

require_once "vendor/autoload.php";

use DeepCode\controllers as Controllers;
use DeepCode\server\Server;

// Core of the project

// configure all services, create router and start redirection

if(Server::IsInitialized() === false){
    // initialize

    $server = Server::GetInstance();

    $server->Router->AddRoute("/", function() {
        $controller = new Controllers\HomeController();

        $controller->Index();
    });

    $server->Router->AddRoute("/problems", function() {
        $controller = new Controllers\ProblemsController();

        $controller->Index();
    });
    $server->Router->AddRoute("/problem", function() {
        $controller = new Controllers\ProblemsController();

        $controller->GetProblem(3);
    });

    $server->Router->AddRoute("/profile", function() {
        include "views/profile.php";
    });
}

$server = Server::GetInstance();

try{
    $server->Router->HandleRoute($_SERVER['REQUEST_URI']);
}catch(Exception){
    echo "Not founded.";
}
