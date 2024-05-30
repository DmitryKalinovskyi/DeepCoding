<?php

namespace DeepCode\Api;

use DeepCode\DTO\UserDTO;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
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

    #[Route('my/submissions')]
    #[Authenticated]
    public function GetMySubmissions(): void{
        $submissions = $this->userRepository->getSubmissions($this->context->user->Id);

        echo json_encode($submissions);
    }

    #[Route('{profileId}/submissions')]
    public function GetSubmissions(int $profileId): void{
        $user =$this->userRepository->find($profileId);
        if(empty($user)){
            echo json_encode("profile not founded");
            http_response_code(404);
            return;
        }

        $submissions = $this->userRepository->getSubmissions($profileId);

        echo json_encode($submissions);
    }
}