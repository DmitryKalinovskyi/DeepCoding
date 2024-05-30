<?php

namespace Framework\Middlewares\Response;

use Framework\Http\HttpContext;

class ResponseMiddleware
{
    public function __invoke(HttpContext $context, $next): void{
        $next();

        // process the response
        if(isset($context->response)){
            /* @var Response $response */
            $response = $context->response;

            http_response_code($response->statusCode);
            foreach($response->headers as $header){
                header($header);
            }
            echo $response->result;
        }
    }
}