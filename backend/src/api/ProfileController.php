<?php

namespace DeepCode\api;

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
    public function MyProfile(){
        echo $this->context->user;
    }
}