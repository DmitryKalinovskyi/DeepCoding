<?php

namespace Framework\Middlewares\Request;

use Framework\Http\HttpContext;

class RequestMiddleware
{
    public function __invoke(HttpContext $context, $next): void{
        // read body and place it in the context
        $context->body = json_decode(file_get_contents("php://input"));
        $next();
    }
}