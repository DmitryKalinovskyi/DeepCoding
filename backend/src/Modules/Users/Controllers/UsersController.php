<?php

namespace DeepCode\Modules\Users\Controllers;

use DeepCode\Models\User;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Authentication\Attributes\Filters\Unauthenticated;
use DeepCode\Modules\Users\DTO\UserDTO;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use DeepCode\Modules\Users\Validation\RegisterValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Services\IPasswordHashingService;
use Framework\Validation\Validator;

class UsersController extends APIController
{
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private IUserRepository $userRepository;
    #[Resolvable]
    private IPasswordHashingService $hashingService;

    #[Route('my')]
    #[Authenticated]
    public function MyProfile(): JsonResponse{
        $dto = new UserDTO();
        AutoMapper::map($this->context->user, $dto);

        return $this->json($dto);
    }

    #[Route('{userId}')]
    public function GetProfile(string $userId): JsonResponse{
        if(!ctype_digit($userId)){
            return $this->json("UserId should be positive integer", 422);
        }

        $userId = (int)$userId;

        $user = $this->userRepository->find($userId);

        if($user == null){
            return $this->json("User not founded", 404);
        }

        $dto = new UserDTO();
        AutoMapper::map($user, $dto);

        return $this->json($dto);
    }

    #[Route("register")]
    #[HttpPost]
    #[Unauthenticated]
    public function Register(): JsonResponse{
        $registerViewModel = new RegisterValidation();
        AutoMapper::mapFromArray($this->context->body, $registerViewModel);

        if(!Validator::isModelValid($registerViewModel)){
            return $this->json((object)["errors" => Validator::getErrors($registerViewModel)]);
        }

        $user = new User();
        AutoMapper::map($registerViewModel, $user);
        // check if exist user with that login
        if(!empty($this->userRepository->findByLogin($user->Login))){
            return $this->json("User with that login already exist.", 422);
        }

        $user->Password = $this->hashingService->hashPassword($registerViewModel->Password);

        $this->userRepository->insert($user);

        return $this->json("Registered.", 200);
    }

    #[Route("{userId}")]
    #[HttpDelete]
    #[Authenticated]
    #[InRole("Admin")]
    public function DeleteUser(string $userId): JsonResponse{
        if(!ctype_digit($userId)){
            return $this->json("UserId should be positive integer", 422);
        }

        $userId = (int)$userId;

        $this->userRepository->delete($userId);

        return $this->json("Deleted.", 200);
    }

//    #[Route("")]
//    #[HttpDelete]
//    #[Authenticated]
//    public function DeleteMe(): JsonResponse{
//        $this->userRepository->delete($this->context->user->Id);
//
//        return $this->json("Deleted.", 200);
//    }
}