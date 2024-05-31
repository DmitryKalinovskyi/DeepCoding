<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Unauthenticated;
use DeepCode\Modules\Authentication\Services\IJWTService;
use DeepCode\Modules\Authentication\Validation\LoginValidation;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Services\IPasswordHashingService;
use Framework\Validation\Validator;

class AuthenticateController extends APIController
{
    #[Resolvable]
    private IJWTService $jwtService;
    #[Resolvable]
    private IUserRepository $userRepository;
    #[Resolvable]
    private IPasswordHashingService $hashingService;
    #[Resolvable]
    private HttpContext $context;

    #[Route("login")]
    #[HttpPost]
    #[Unauthenticated]
    public function Login(): JsonResponse{
        $validationModel = AutoMapper::map($this->context->body, new LoginValidation());

        if(!Validator::isModelValid($validationModel)){
            return $this->json(Validator::getErrors($validationModel), 422);
        }

        // receive credentials and use them in authentication service
        $login = $validationModel->login;
        $password = $validationModel->password;

        $user = $this->userRepository->findByLogin($login);

        if($user === null){
            return $this->json("Not founded", 404);
        }

        if($this->hashingService->isMatch($password, $user->Password)){
            return $this->json($this->jwtService->getToken($login), 200);
        }
        else{
            return $this->json("Invalid login")
//                ->header('WWW-Authenticate', 'Bearer')
                ->status(401);
        }
    }
}