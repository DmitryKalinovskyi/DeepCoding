<?php

namespace DeepCode\Api;

use DeepCode\Attributes\Filters\Authenticated;
use DeepCode\Repositories\Interfaces\IUserRepository;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\MVC\APIController;

class ProfilesController extends APIController
{
    private HttpContext $context;
    private IUserRepository $userRepository;
    public function __construct(HttpContext $context, \DeepCode\Repositories\Interfaces\IUserRepository $userRepository){
        $this->context = $context;
        $this->userRepository = $userRepository;
    }

    #[Route('my')]
    #[Authenticated]
    public function MyProfile(): void{
        echo json_encode($this->context->user);
    }

    #[Route('{profileId}')]
    public function GetProfile(int $profileId): void{
        echo json_encode($this->userRepository->find($profileId));
    }
}