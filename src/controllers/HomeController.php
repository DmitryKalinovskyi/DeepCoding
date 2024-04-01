<?php

namespace DeepCode\controllers;

use Framework\mvc\ControllerBase;

class HomeController extends ControllerBase{
    public function __construct(){

    }

    public function Index(): void{
        $this->render('home.php', ['msg' => "Hello and welcome to the DeepCoding!"]);
    }
}