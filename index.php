<?php

require_once "framework/server.php";

// Core of the project

// configure all services, create router and start redirection

if(Server::$Instance === null){
    // initialize

    $server = Server::GetInstance();

    $server->Router->AddRoute("/problems", function() {
        include_once "views/problems.php";
    });
    $server->Router->AddRoute("/problem", function() {
        include_once "views/problem.php";
    });
}

$server = Server::GetInstance();

try{
    $server->Router->HandleRoute($_SERVER['REQUEST_URI']);
}catch(Exception){
    echo "Not founded.";
}
