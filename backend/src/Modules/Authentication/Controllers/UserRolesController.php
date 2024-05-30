<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Authentication\Repositories\IUser_RolesRepository;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

#[Route('users')]
class UserRolesController extends APIController
{
    private IUser_RolesRepository $user_RolesRepository;

    private HttpContext $context;

    public function __construct(IUser_RolesRepository $user_RolesRepository, HttpContext $context){

        $this->user_RolesRepository = $user_RolesRepository;
        $this->context = $context;
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    public function GetUserRoles(int $userId): JsonResponse{
        return $this->json($this->user_RolesRepository->getUserRoles($userId));
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpPost]
    public function AddUserRole(int $userId): JsonResponse{
        if(empty($this->context->body->roleId)){
            return $this->json("Role id field is required.", 422);
        }

        $roleId = $this->context->body->roleId;

        $this->user_RolesRepository->addRoleForUser($userId, $roleId);

        return $this->json("Added.", 200);
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpDelete]
    public function RemoveUserRole(int $userId): JsonResponse{
        if(empty($this->context->body->roleId)){
            return $this->json("Role id field is required.", 422);
        }

        $roleId = $this->context->body->roleId;

        $this->user_RolesRepository->removeRoleForUser($userId, $roleId);
        return $this->json("Removed.", 200);
    }
}