<?php

namespace DeepCode\Modules\Users\Controllers;

use DeepCode\DTO\UserDTO;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\MVC\APIController;

class UsersController extends APIController
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

    #[Route('{userId}')]
    public function GetProfile(int $userId): void{
        $user = $this->userRepository->find($userId);

        if($user == null){
            http_response_code(404);
            echo json_encode("User not founded");
            return;
        }

        $dto = new UserDTO();
        AutoMapper::map($user, $dto);

        echo json_encode($dto);
    }

    #[Route('my/submissions')]
    #[Authenticated]
    public function GetMySubmissions(): void{
        $submissions = $this->userRepository->getSubmissions($this->context->user->Id);

        echo json_encode($submissions);
    }

    #[Route('{profileId}/submissions')]
    public function GetSubmissions(int $profileId): void{
        $user = $this->userRepository->find($profileId);
        if(empty($user)){
            echo json_encode("profile not founded");
            http_response_code(404);
            return;
        }

        $submissions = $this->userRepository->getSubmissions($profileId);

        echo json_encode($submissions);
    }
}