<?php

namespace DeepCode\Modules\Scheme\Controllers;

use Framework\attributes\Routing\Route;
use Framework\Middlewares\Response\JsonResponse;
use Framework\Middlewares\Routing\Router;
use Framework\MVC\APIController;

class SchemeController extends APIController
{
    private Router $router;
    public function __construct(Router $router){
        $this->router = $router;
    }

    #[Route('routes')]
    public function GetRoutes(): JsonResponse{
        return $this->json((object)["routes" => $this->router->getRoutes()]);
    }
}