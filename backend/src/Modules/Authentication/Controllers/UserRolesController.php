<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Authentication\Repositories\IRolesRepository;
use DeepCode\Modules\Authentication\Repositories\IUser_RolesRepository;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;

#[Route('users')]
class UserRolesController
{
    private IUser_RolesRepository $user_RolesRepository;

    public function __construct(\DeepCode\Modules\Authentication\Repositories\IUser_RolesRepository $user_RolesRepository){

        $this->user_RolesRepository = $user_RolesRepository;
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    public function GetUserRoles(int $userId): void{
        echo json_encode($this->user_RolesRepository->getUserRoles($userId));
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpPost]
    public function AddUserRole(int $userId): void{
        if(empty($_POST['roleId'])){
            http_response_code(422);
            return;
        }

        $roleId = $_POST['roleId'];

        $this->user_RolesRepository->addRoleForUser($userId, $roleId);
    }

    #[Route("{userId}/roles")]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpDelete]
    public function RemoveUserRole(int $userId): void{
        $body = file_get_contents('php://input');

        if(!isset($_POST['roleId'])){
            http_response_code(422);
            return;
        }

        $roleId = $_POST['roleId'];

        $this->user_RolesRepository->removeRoleForUser($userId, $roleId);
    }
}