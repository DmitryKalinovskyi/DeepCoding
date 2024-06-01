<?php

namespace DeepCode\Modules\Users\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\User;

class UserRepository implements IUserRepository
{
    private DeepCodeContext $db;

    public function __construct(DeepCodeContext $context){

        $this->db = $context;
    }

    public function insert($model): void
    {
        $this->db->users->insert($model);
    }

    public function find($key): mixed
    {
        return $this->db->users->select()
            ->where("Id = :id")
            ->first([':id' => $key]);
    }

    public function update($key, object $model): void
    {
        $this->db->users->dynamicUpdate($model)
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }

    public function delete($key): void
    {
        $this->db->users->delete()
            ->where("Id = :id")
            ->execute([':id' => $key]);
    }

    public function findByLogin(string $login): ?User
    {
        return $this->db->users->select()
            ->where("Login = :login")
            ->first([':login' => $login]);
    }

    public function exist(string $userId): bool
    {
        return $this->db->users->select()
            ->where("Id = :id")
            ->useParams([':id' => $userId])
            ->count();
    }

    public function search(UsersSearchParams $params): array
    {
        $query = $this->db->users->select()
            ->offset($params->page * $params->pageSize)
            ->limit($params->pageSize);

        if($params->login != null){
            $titleWildcard = "%$params->login%";
            $query->where("Title LIKE :title")
                ->useParams([":title" => $titleWildcard]);
        }

        return $query->execute();
    }

    public function searchCount(UsersSearchParams $params): int
    {
        $query = $this->db->users->select();

        if($params->login != null){
            $titleWildcard = "%$params->login%";
            $query->where("Title LIKE :title")
                ->useParams([":title" => $titleWildcard]);
        }

        return $query->count();
    }
}