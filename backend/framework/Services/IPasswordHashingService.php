<?php

namespace Framework\Services;

interface IPasswordHashingService
{
    public function hashPassword(string $password): string;

    public function isMatch(string $password, string $passwordHash): bool;
}