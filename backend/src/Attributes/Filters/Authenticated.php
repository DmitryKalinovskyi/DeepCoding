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
    public function ok(HttpContext $context): bool
    {
        return isset($context->user);
    }
}