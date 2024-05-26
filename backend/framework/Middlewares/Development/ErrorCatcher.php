<?php

namespace Framework\Middlewares\Development;

class ErrorCatcher
{
    public function __invoke(mixed $next): void{
        try{
            $next();
        }catch (\Exception $e){
            echo $e->getMessage();

            var_dump($e);
        }
    }
}