<?php

namespace DeepCode\Attributes\Filters;

use Attribute;
use Framework\Attributes\Filters\RequestFilterAttribute;
use Framework\Http\HttpContext;

#[Attribute]
class Authenticated extends RequestFilterAttribute
{
    /**
     * @param HttpContext $context - context for the request
     * @return bool - true if $context->user authenticated by middleware
     */
    public function filter(HttpContext $context): bool
    {
        if(!isset($context->user)){
            http_response_code(401);
        }
        return isset($context->user);
    }
}