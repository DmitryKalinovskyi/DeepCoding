<?php

require_once "server/server.php";
require_once "controllers/homeController.php";

//$msg = "test 12";
//function write($var): void{
//    global $$var;
//    echo $$var ??  "<div class='text-light bg-danger p-2 rounded-2'>Variable with name \"$var\" is unset</div>";
//}
//
//write("msg");
//die();


// Core of the project

// configure all services, create router and start redirection

if(Server::IsInitialized() === false){
    // initialize

    $server = Server::GetInstance();

    $server->Router->AddRoute("/", function() {
        $controller = new HomeController();

        $controller->Index();
    });

    $server->Router->AddRoute("/problems", function() {
        include "views/problems.php";
    });
    $server->Router->AddRoute("/problem", function() {
        include "views/problem.php";
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
