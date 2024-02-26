<?php


namespace DeepCode\server;

use Framework\routing\Router;

class Server{
    private static ?Server $_instance = null;
    public Router $Router;
    private function __construct(){
        $this->Router = new Router();
    }

    public static function IsInitialized(): bool{
        return self::$_instance != null;
    }

    public static function GetInstance(): Server{
        if(self::$_instance === null){
            return self::$_instance = new Server();
        }

        return self::$_instance;
    }
}