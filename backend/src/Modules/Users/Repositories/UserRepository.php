<?php

namespace DeepCode\Modules\Users\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\User;

class UserRepository implements IUserRepository
{
    private DeepCodeContext $context;

    public function __construct(DeepCodeContext $context){

        $this->context = $context;
    }

    public function insert($model): void
    {
        $this->context->users->insert($model);
    }

    public function find($key): mixed
    {
        return $this->context->users->select()
            ->where("Id = :id")
            ->first([':id' => $key]);
    }

    public function update($key, object $model): void
    {
        $this->context->users->dynamicUpdate($model)
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }

    public function delete($key): void
    {
        $this->context->users->delete()
            ->where("Id = :id")
            ->execute([':id' => $key]);
    }

    public function isRegistered(string $login, string $hashedPassword): bool
    {
        return $this->context->users->select()
            ->where("Login = :login and Password = :password")
            ->first([':login' => $login, ":password" => $hashedPassword]) != null;
    }

    public function findByLogin(string $login): ?User
    {
        return $this->context->users->select()
            ->where("Login = :login")
            ->first([':login' => $login]);
    }

    public function exist(string $userId): bool
    {
        return $this->context->users->select()
            ->where("Id = :id")
            ->useParams([':id' => $userId])
            ->count();
    }
}