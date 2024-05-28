<?php

namespace DeepCode\Api;

use DeepCode\Attributes\Filters\Authenticated;
use DeepCode\DTO\UserDTO;
use DeepCode\Repositories\Interfaces\IUserRepository;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\MVC\APIController;

class ProfilesController extends APIController
{
    private HttpContext $context;
    private IUserRepository $userRepository;
    public function __construct(HttpContext $context, IUserRepository $userRepository){
        $this->context = $context;
        $this->userRepository = $userRepository;
    }

    #[Route('my')]
    #[Authenticated]
    public function MyProfile(): void{
        $dto = new UserDTO();
        AutoMapper::map($this->context->user, $dto);

        echo json_encode($dto);
    }

    #[Route('{profileId}')]
    public function GetProfile(int $profileId): void{
        $user = $this->userRepository->find($profileId);
        $dto = new UserDTO();
        AutoMapper::map($user, $dto);

        echo json_encode($dto);
    }
}