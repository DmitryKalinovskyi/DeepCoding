<?php

namespace DeepCode\Modules\Users\Repositories;

use DeepCode\Models\User;
use DeepCode\Repositories\IRepository;

interface IUserRepository extends IRepository
{
    public function findByLogin(string $login): ?User;

    public function exist(string $userId): bool;
}