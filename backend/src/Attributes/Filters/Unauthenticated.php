<?php

namespace DeepCode\Attributes\Filters;

use Framework\Attributes\Filters\RequestFilterAttribute;
use Framework\Http\HttpContext;

#[\Attribute]
class Unauthenticated extends RequestFilterAttribute
{

    public function ok(HttpContext $context): bool
    {
        return false;
    }
}