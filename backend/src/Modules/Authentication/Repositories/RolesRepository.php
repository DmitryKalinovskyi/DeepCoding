<?php

namespace DeepCode\Modules\Authentication\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\Role;

class RolesRepository implements IRolesRepository
{
    private DeepCodeContext $context;

    public function __construct(DeepCodeContext $context){

        $this->context = $context;
    }


    public function insert($model): void
    {
        $this->context->roles->insert($model);
    }

    public function find($key): mixed
    {
        return $this->context->roles->select()
            ->where('Id = :id')
            ->first([":id" => $key]);
    }

    public function update($key, $model): void
    {
        // TODO: Implement update() method.
    }

    public function delete($key): void
    {
        $this->context->roles->delete()
            ->where('Id = :id')
            ->execute([":id" => $key]);
    }

    public function getRoles(): array
    {
        return $this->context->roles->select()->execute();
    }

    public function getRoleByName(string $roleName): ?Role
    {
        return $this->context->roles->select()
            ->where('Name = :name')
            ->first([":name" => $roleName]);
    }
}