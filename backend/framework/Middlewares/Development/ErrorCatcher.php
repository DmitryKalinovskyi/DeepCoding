<?php

namespace Framework\Middlewares\Development;

class ErrorCatcher
{
    public function __invoke(mixed $next): void{
        try{
            $next();
        }catch (\Exception $e){
            echo $e->getMessage();
//            http_response_code(500);
            var_dump($e);
        }
        catch (\Error $e){
            echo $e->getMessage();
//            http_response_code(500);
            var_dump($e);
        }
    }
}