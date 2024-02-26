<?php

require_once "framework/mvc/controllerBase.php";

class HomeController extends ControllerBase{
    public function __construct(){

    }

    public function Index(){
        $this->Render('home.php', ['msg' => "Hello and welcome to the DeepCoding!"]);
    }
}