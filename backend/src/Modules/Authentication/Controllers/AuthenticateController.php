<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Models\User;
use DeepCode\Modules\Authentication\Attributes\Filters\Unauthenticated;
use DeepCode\Modules\Authentication\Services\IJWTService;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use DeepCode\ViewModels\RegisterViewModel;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Mapper\AutoMapper;
use Framework\MVC\APIController;
use Framework\Services\IPasswordHashingService;
use Framework\Validation\Validator;

class AuthenticateController extends APIController
{
    private IJWTService $jwtService;
    private IUserRepository $userRepository;

    private IPasswordHashingService $hashingService;

    public function __construct(IJWTService $jwtService,
                                IUserRepository $userRepository,
                                IPasswordHashingService $hashingService){

        $this->jwtService = $jwtService;
        $this->userRepository = $userRepository;
        $this->hashingService = $hashingService;
    }

    #[Route("login")]
    #[HttpPost]
    #[Unauthenticated]
    public function Login(): void{
        // receive credentials and use them in authentication service
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user = $this->userRepository->findByLogin($login);

        if($user === null){
            echo json_encode("Not founded");
            return;
        }

        if($this->hashingService->isMatch($password, $user->Password)){
            echo json_encode($this->jwtService->getToken($login));
        }
        else{
            echo json_encode("Invalid login");
        }
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