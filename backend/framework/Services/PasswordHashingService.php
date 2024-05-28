<?php

namespace Framework\Services;

class PasswordHashingService implements IPasswordHashingService
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function isMatch(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
}