<?php

namespace DeepCode\Modules\Authentication\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\User_Role;

class User_RolesRepository implements IUser_RolesRepository
{
    private DeepCodeContext $context;

    public function __construct(\DeepCode\DB\DeepCodeContext $context){

        $this->context = $context;
    }

    public function getUserRoles($userId): array
    {
        return $this->context->roles->select(['R.Id', 'R.Name'])
            ->from(DeepCodeContext::ROLES_TABLE . " as R")
            ->innerJoin(DeepCodeContext::USER_ROLES_TABLE . " as UR", "UR.RoleId = R.Id")
            ->innerJoin(DeepCodeContext::USERS_TABLE . " as U", "U.Id = UR.UserId")
            ->where("U.Id = :userId")
            ->execute([":userId"=>$userId]);
    }

    public function addRoleForUser($userId, $roleId): void{
        $user_role = new User_Role();
        $user_role->UserId = $userId;
        $user_role->RoleId = $roleId;

        $this->context->user_roles->insert($user_role);
    }

    public function removeRoleForUser($userId, $roleId): void
    {
        $this->context->user_roles->delete()
            ->where("UserId = :userId AND RoleId = :roleId")
            ->execute([':userId' => $userId, ':roleId' => $roleId]);
    }

    public function isUserHaveRole($userId, $roleId): bool
    {
        return $this->context->user_roles->select()
                ->where("UserId = :userId AND RoleId = :roleId")
                ->first([':userId' => $userId, ':roleId' => $roleId]) != null;
    }
}