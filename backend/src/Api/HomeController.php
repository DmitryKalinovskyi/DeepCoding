<?php

namespace DeepCode\Api;

use Framework\attributes\Routing\Route;
use Framework\MVC\APIController;

#[Route("/")]
#[Route("home")]
class HomeController extends APIController {
    #[Route("/")]
    #[Route("index")]
    public function Index(): void{
        echo json_encode(['msg' => "Hello and welcome to the DeepCoding!"]);
    }
}