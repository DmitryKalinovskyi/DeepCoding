<?php

namespace DeepCode\controllers;

use Framework\attributes\Routing\Route;
use Framework\mvc\ControllerBase;

class HomeController extends ControllerBase{
    #[Route("/")]
    #[Route("index")]
    public function Index(): void{
        $this->render('home.php', ['msg' => "Hello and welcome to the DeepCoding!"]);
    }
}