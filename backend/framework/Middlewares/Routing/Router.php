<?php

namespace Framework\Middlewares\Routing;

use Exception;

class Router{

    public RouterMethod $get;
    public RouterMethod $post;
    public RouterMethod $put;
    public RouterMethod $patch;
    public RouterMethod $delete;
    public RouterMethod $options;

    public function __construct(){
        $this->get = new RouterMethod();
        $this->post = new RouterMethod();
        $this->put = new RouterMethod();
        $this->patch = new RouterMethod();
        $this->delete = new RouterMethod();
        $this->options = new RouterMethod();
    }

    public function getAction(string $route): callable{
        $methodMappings = [
            "GET" => $this->get,
            "POST" => $this->post,
            "PUT" => $this->put,
            "PATCH" => $this->patch,
            "DELETE" => $this->delete,
            "OPTIONS" => $this->options,
        ];

        return $methodMappings[$_SERVER['REQUEST_METHOD']]->getAction($route);
    }


//    public function getRouteParameters(string $route): array{
//        // all parameters should be inside curly brackets
//        //TODO: parse parameters
//        return [];
//    }

    public function dump_routes(): void{
        echo "GET ROUTES: ";
        var_dump($this->get);

        echo "POST ROUTES: ";
        var_dump($this->post);

        echo "PATCH ROUTES: ";
        var_dump($this->patch);

        echo "PUT ROUTES: ";
        var_dump($this->put);

        echo "DELETE ROUTES: ";
        var_dump($this->delete);
    }
}