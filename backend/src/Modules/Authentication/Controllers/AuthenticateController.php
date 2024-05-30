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
}