<?php

namespace DeepCode\Modules\Authentication\Repositories;

use DeepCode\Repositories\IRepository;

interface IUser_RolesRepository
{
    public function getUserRoles($userId): array;

    public function addRoleForUser($userId, $roleId): void;

    public function removeRoleForUser($userId, $roleId): void;

    public function isUserHaveRole($userId, $roleId): bool;
}