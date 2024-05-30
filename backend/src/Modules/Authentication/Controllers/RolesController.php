<?php

namespace DeepCode\Modules\Authentication\Controllers;

use DeepCode\Models\Role;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Authentication\Repositories\IRolesRepository;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

class RolesController extends APIController
{
    private IRolesRepository $rolesRepository;
    private HttpContext $context;

    public function __construct(IRolesRepository $rolesRepository, HttpContext $context){

        $this->rolesRepository = $rolesRepository;
        $this->context = $context;
    }
    #[Route('')]
    #[Authenticated]
    #[InRole("Admin")]
    public function GetRoles(): JsonResponse{
        return $this->json($this->rolesRepository->getRoles());
    }

    #[Route('')]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpPost]
    public function CreateRole(): JsonResponse{
        $role = new Role();
        AutoMapper::mapFromArray($this->context->body, $role);
        $this->rolesRepository->insert($role);

        return $this->json("Created.", 200);
    }

    #[Route('{roleId}')]
    #[Authenticated]
    #[InRole("Admin")]
    #[HttpDelete]
    public function DeleteRole(int $roleId): JsonResponse{
        $this->rolesRepository->delete($roleId);

        return $this->json("Deleted.", 200);
    }
}