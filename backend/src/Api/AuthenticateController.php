<?php

namespace DeepCode\Api;

use DeepCode\Attributes\Filters\Unauthenticated;
use DeepCode\Repositories\Interfaces\IUserRepository;
use DeepCode\Services\IJWTService;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\MVC\APIController;

class AuthenticateController extends APIController
{
    private IJWTService $jwtService;
    private IUserRepository $userRepository;

    public function __construct(\DeepCode\Services\IJWTService $jwtService, \DeepCode\Repositories\Interfaces\IUserRepository $userRepository){

        $this->jwtService = $jwtService;
        $this->userRepository = $userRepository;
    }

    #[Route("login")]
    #[HttpPost]
    #[Unauthenticated]
    public function Login(): void{
        // receive credentials and use them in authentication service
        $login = $_POST['login'];
        $password = $_POST['password'];

        if($this->userRepository->isRegistered($login, $password)){
            echo json_encode($this->jwtService->getToken($login));
        }
        else{
            echo json_encode("Invalid login");
        }
    }

    #[Route("register")]
    #[HttpPost]
    #[Unauthenticated]
    public function Register(){


    }
}