<?php

require_once 'router.php';

class Server{

    public static ?Server $Instance = null;

    public Router $Router;
    public function __construct(){
        $this->Router = new Router();
    }

    public static function GetInstance(){
        if(self::$Instance === null){
            return self::$Instance = new Server();
        }

        return self::$Instance;
    }
}