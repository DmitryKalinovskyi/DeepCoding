<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Models\Role;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Authentication\Repositories\IRolesRepository;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Mapper\AutoMapper;

class RolesController
{
    private IRolesRepository $rolesRepository;

    public function __construct(\DeepCode\Modules\Authentication\Repositories\IRolesRepository $rolesRepository){

        $this->rolesRepository = $rolesRepository;
    }
    #[Route('')]
    #[Authenticated]
    #[InRole("Admin")]
    public function GetRoles(): void{
        echo json_encode($this->rolesRepository->getRoles());
    }

    #[Route('')]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpPost]
    public function CreateRole(): void{
        $role = new Role();
        AutoMapper::mapFromArray($_POST, $role);
        $this->rolesRepository->insert($role);
    }

    #[Route('{roleId}')]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpDelete]
    public function DeleteRole(int $roleId): void{
        $this->rolesRepository->delete($roleId);
    }
}