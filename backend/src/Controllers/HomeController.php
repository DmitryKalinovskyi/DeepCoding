<?php

namespace DeepCode\Controllers;

use Framework\attributes\Routing\Route;
use Framework\MVC\ControllerBase;

#[Route("/")]
#[Route("home")]
class HomeController extends ControllerBase{
    #[Route("/")]
    #[Route("index")]
    public function Index(): void{
        $this->render('home.php', ['msg' => "Hello and welcome to the DeepCoding!"]);
    }
}