<?php

namespace DeepCode\Modules\Authentication\Repositories;

use DeepCode\Models\Role;
use DeepCode\Repositories\IRepository;


interface IRolesRepository extends IRepository
{
    public function getRoles(): array;

    public function getRoleByName(string $roleName): ?Role;

}