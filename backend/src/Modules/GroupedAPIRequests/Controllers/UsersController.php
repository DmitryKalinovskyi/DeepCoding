<?php

namespace DeepCode\Modules\GroupedAPIRequests\Controllers;

use DeepCode\Modules\GroupedAPIRequests\Repositories\IUsersGroupedRepository;
use Framework\Attributes\Dependency\Resolvable;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

class UsersController extends APIController
{
    #[Resolvable]
    private IUsersGroupedRepository $usersGroupedRepository;

    #[Resolvable]
    private HttpContext $context;

    #[Route('{userId}')]
    public function GetUser(string $userId): JsonResponse{
        if(!ctype_digit($userId)){
            return $this->json("UserId should be positive integer", 422);
        }

        $userId = (int)$userId;

        $user = $this->usersGroupedRepository->getUser($userId, $this->context->user->Id ?? -1);

        if($user == null){
            return $this->json("User not founded", 404);
        }

        return $this->json($user, 200);
    }
}