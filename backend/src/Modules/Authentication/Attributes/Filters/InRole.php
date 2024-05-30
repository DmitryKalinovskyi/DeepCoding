<?php

namespace DeepCode\Modules\Authentication\Attributes\Filters;

use Framework\Attributes\Filters\RequestFilterAttribute;
use Framework\Http\HttpContext;

#[\Attribute]
class InRole extends RequestFilterAttribute
{
    private string $roleName;
    public function __construct(string $roleName){
        $this->roleName = $roleName;
    }

    public function filter(HttpContext $context): bool
    {
        if(!isset($context->roles)){
            http_response_code(401);
            return false;
        }

        $inRole = false;
        foreach($context->roles as $role){
            if($role->Name == $this->roleName){
                $inRole = true;
            }
        }

        return $inRole;
    }
}