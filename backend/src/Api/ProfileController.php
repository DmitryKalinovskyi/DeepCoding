<?php

namespace DeepCode\Api;

use Framework\attributes\Filters\Authenticated;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\MVC\APIController;

class ProfileController extends APIController
{
    private HttpContext $context;
    public function __construct(HttpContext $context){
        $this->context = $context;
    }

    #[Route('my')]
    #[Authenticated]
    public function MyProfile(){
        var_dump($this->context->user);
    }
}