<?php

namespace DeepCode\Middlewares;

use Framework\Http\HttpContext;
use Framework\middlewares\Authentication\IAuthenticationMiddleware;

class JWTAuthenticationMiddleware implements IAuthenticationMiddleware
{
    public function __invoke(HttpContext $context, $next){
        $context->user = "Dmytro Kalinovskyi";

        $next();
    }
}