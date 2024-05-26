<?php

namespace Framework\Middlewares\Routing;

use Exception;

class ControllerRouter{

    public ControllerRouterMethod $post;
    public ControllerRouterMethod $get;
    public ControllerRouterMethod $patch;
    public ControllerRouterMethod $delete;
    public ControllerRouterMethod $put;

    public function __construct(){
        $this->post = new ControllerRouterMethod();
        $this->put = new ControllerRouterMethod();
        $this->delete = new ControllerRouterMethod();
        $this->patch = new ControllerRouterMethod();
        $this->get = new ControllerRouterMethod();
    }

    /**
     * @throws Exception
     */
    public function redirect($url){
        switch($_SERVER['REQUEST_METHOD'] ){
            case "POST":
                $this->post->handleRoute($url);
                break;
            case "GET":
                $this->get->handleRoute($url);
                break;
            case "PATCH":
                $this->patch->handleRoute($url);
                break;
            case "PUT":
                $this->put->handleRoute($url);
                break;
            case "DELETE":
                $this->delete->handleRoute($url);
                break;
            default:
                throw new Exception("Unsupported request method exception");
        }
    }

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