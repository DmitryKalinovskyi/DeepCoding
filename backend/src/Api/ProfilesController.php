<?php

namespace DeepCode\Api;

use Framework\attributes\Filters\Authenticated;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\MVC\APIController;

class ProfilesController extends APIController
{
    private HttpContext $context;
    public function __construct(HttpContext $context){
        $this->context = $context;
    }

    #[Route('my')]
    #[Authenticated]
    public function MyProfile(): void{
        echo json_encode($this->context->user);
    }

    #[Route('{profileId}')]
    public function GetProfile(int $profileId): void{
        echo "user $profileId";
    }
}