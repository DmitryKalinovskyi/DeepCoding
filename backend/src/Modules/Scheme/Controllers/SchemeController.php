<?php

namespace DeepCode\Modules\Scheme\Controllers;

use Framework\Attributes\Dependency\Resolvable;
use Framework\attributes\Routing\Route;
use Framework\Middlewares\Response\JsonResponse;
use Framework\Middlewares\Routing\Router;
use Framework\MVC\APIController;

class SchemeController extends APIController
{
    #[Resolvable]
    private Router $router;

    #[Route('routes')]
    public function GetRoutes(): JsonResponse{
        return $this->json((object)["routes" => $this->router->getRoutes()]);
    }
}