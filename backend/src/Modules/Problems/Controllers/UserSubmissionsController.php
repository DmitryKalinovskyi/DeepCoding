<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Attributes\Dependency\Resolvable;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

#[Route("users")]
class UserSubmissionsController extends APIController
{
    #[Resolvable]
    private ISubmissionsRepository $submissionsRepository;
    #[Resolvable]
    private IUserRepository $userRepository;

    #[Resolvable]
    private HttpContext $context;

    #[Route('my/submissions')]
    #[Authenticated]
    public function GetMySubmissions(): JsonResponse{
        return $this->json($this->submissionsRepository->getUserSubmissions($this->context->user->Id), 200);
    }

    #[Route('{userId}/submissions')]
    public function GetSubmissions(string $userId): JsonResponse{
        $user = $this->userRepository->find($userId);
        if(empty($user)){
            return $this->json("Not founded.", 404);
        }

        return $this->json($this->submissionsRepository->getUserSubmissions($userId), 200);
    }
}