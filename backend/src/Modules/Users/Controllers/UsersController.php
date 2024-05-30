<?php

namespace DeepCode\Modules\Users\Controllers;

use DeepCode\DTO\UserDTO;
use DeepCode\Models\User;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\Unauthenticated;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use DeepCode\ViewModels\RegisterViewModel;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\MVC\APIController;
use Framework\Services\IPasswordHashingService;
use Framework\Validation\Validator;

class UsersController extends APIController
{
    private HttpContext $context;
    private IUserRepository $userRepository;
    private IPasswordHashingService $hashingService;

    public function __construct(HttpContext $context, IUserRepository $userRepository, IPasswordHashingService $hashingService){
        $this->context = $context;
        $this->userRepository = $userRepository;
        $this->hashingService = $hashingService;
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

    #[Route("register")]
    #[HttpPost]
    #[Unauthenticated]
    public function Register(): void{
        $registerViewModel = new RegisterViewModel();
        AutoMapper::mapFromArray($_POST, $registerViewModel);

        if(!Validator::isModelValid($registerViewModel)){
            echo json_encode(Validator::getErrorMessage($registerViewModel));
            return;
        }

        $user = new User();
        AutoMapper::map($registerViewModel, $user);
        // check if exist user with that login
        if(!empty($this->userRepository->findByLogin($user->Login))){
            echo json_encode("User with that login already exist.");
            return;
        }

        $user->Password = $this->hashingService->hashPassword($_POST['password']);

        $this->userRepository->insert($user);
    }
}