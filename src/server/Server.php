<?php


namespace DeepCode\server;

use DeepCode\db\DeepCodeContext;
use Framework\routing\Router;

class Server{
    private static ?Server $_instance = null;
    public Router $router;
    public DeepCodeContext $deepCodeContext;

    private function __construct(){
        $this->router = new Router();
    }

    public static function isInitialized(): bool{
        return self::$_instance != null;
    }

    public static function getInstance(): Server{
        if(self::$_instance === null){
            return self::$_instance = new Server();
        }

        return self::$_instance;
    }
}