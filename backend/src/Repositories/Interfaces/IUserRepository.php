<?php

namespace DeepCode\Repositories\Interfaces;

use DeepCode\Models\PlatformUser;

interface IUserRepository extends IRepository
{
    public function isRegistered(string $login, string $hashedPassword): bool;

    public function findByLogin(string $login): ?PlatformUser;
}