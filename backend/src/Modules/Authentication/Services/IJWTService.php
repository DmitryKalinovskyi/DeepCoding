<?php

namespace DeepCode\Services;

interface IJWTService
{
    public function getToken(string|array $data): string;
    public function parseToken(string $token): string|array;
    public function isTokenValid(string $token): bool;
}