<?php

namespace Framework\Middlewares\Cors;

class CORS
{
    public function __invoke($next): void{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        $next();
    }
}