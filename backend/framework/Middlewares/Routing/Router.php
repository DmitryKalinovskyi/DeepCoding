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

    public function getRouteAction(string $route): RouteAction{
        $methodMappings = [
            "GET" => $this->get,
            "POST" => $this->post,
            "PUT" => $this->put,
            "PATCH" => $this->patch,
            "DELETE" => $this->delete,
            "OPTIONS" => $this->options,
        ];

        return $methodMappings[$_SERVER['REQUEST_METHOD']]->getRouteAction($route);
    }

    public function dump_routes(): void{
        $this->get->dump_routes("Get");
        $this->post->dump_routes("Post");
        $this->put->dump_routes("Put");
        $this->patch->dump_routes("Patch");
        $this->delete->dump_routes("Delete");
        $this->options->dump_routes("Options");
    }
}