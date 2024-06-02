<?php

namespace DeepCode\Modules\Authentication\Services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService implements IJWTService
{
    private const ALG = "HS256";

    public function getToken(array|string $data): string
    {
        $issuedAt = time();

        $payload = [
            'iat' => $issuedAt,
            'nbf' => $issuedAt,
            'data' => $data
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], self::ALG);
    }

    public function isTokenValid(string $token): bool
    {
        try{
            // Decode the token to check its validity
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], self::ALG));


            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function parseToken(string $token): string|array
    {
        return JWT::decode($token, new Key($_ENV['JWT_SECRET'], self::ALG))->data;
    }
}