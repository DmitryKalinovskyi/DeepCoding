<?php

namespace DeepCode\Repositories\Implementation;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\PlatformUser;
use DeepCode\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    private DeepCodeContext $context;

    public function __construct(DeepCodeContext $context){

        $this->context = $context;
    }

    public function insert($model): void
    {
        $this->context->platformUsers->insert($model);
    }

    public function find($key): mixed
    {
        return $this->context->platformUsers->select()
            ->where("Id = :id")
            ->first([':id' => $key]);
    }

    public function update($key, $model): void
    {
        // TODO: Implement update() method.
    }

    public function delete($key): void
    {
        $this->context->platformUsers->delete()
            ->where("Id = :id")
            ->execute([':id' => $key]);
    }

    public function isRegistered(string $login, string $hashedPassword): bool
    {
        return $this->context->platformUsers->select()
            ->where("Login = :login and Password = :password")
            ->first([':login' => $login, ":password" => $hashedPassword]) != null;
    }

    public function findByLogin(string $login): ?PlatformUser
    {
        return $this->context->platformUsers->select()
            ->where("Login = :login")
            ->first([':login' => $login]);
    }

    public function getSubmissions(string $key): array
    {
        return $this->context->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler'])
            ->innerJoin(DeepCodeContext::PLATFORM_USERS_TABLE." as P", "P.Id = S.UserId")
            ->where("P.Id = :id")
            ->execute([":id" => $key]);
    }
}