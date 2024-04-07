<?php

namespace Framework\routing;

use Exception;

class Router{

    public RouterMethod $post;
    public RouterMethod $get;
    public RouterMethod $patch;
    public RouterMethod $delete;
    public RouterMethod $put;

    public function __construct(){
        $this->post = new RouterMethod();
        $this->put = new RouterMethod();
        $this->delete = new RouterMethod();
        $this->patch = new RouterMethod();
        $this->get = new RouterMethod();
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