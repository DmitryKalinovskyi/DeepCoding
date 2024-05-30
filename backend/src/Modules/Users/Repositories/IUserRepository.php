<?php

namespace DeepCode\Modules\Users\Repositories;

use DeepCode\Models\User;
use DeepCode\Repositories\IRepository;

interface IUserRepository extends IRepository
{
    public function isRegistered(string $login, string $hashedPassword): bool;

    public function findByLogin(string $login): ?User;

    public function getSubmissions(string $key): array;
}