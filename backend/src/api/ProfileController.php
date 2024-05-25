<?php

namespace DeepCode\api;

use Framework\attributes\Filters\Authenticated;
use Framework\attributes\Routing\Route;
use Framework\http\HttpContext;
use Framework\mvc\APIController;

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