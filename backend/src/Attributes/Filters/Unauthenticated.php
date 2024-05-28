<?php

namespace DeepCode\Attributes\Filters;

use Framework\Attributes\Filters\RequestFilterAttribute;
use Framework\Http\HttpContext;

#[\Attribute]
class Unauthenticated extends RequestFilterAttribute
{

    public function filter(HttpContext $context): bool
    {
        if(isset($context->user)){
            http_response_code(403);
            echo "You need to log out";
        }

        return !isset($context->user);
    }
}