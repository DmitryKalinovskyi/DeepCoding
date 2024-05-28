<?php

namespace DeepCode\Services;

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
            'iss' => "https",
            'aud' => "https",
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

            // You can add additional validation logic here if necessary
            // For example, you can check the 'iss' and 'aud' claims
            if ($decoded->iss !== "https" || $decoded->aud !== "https") {
                return false;
            }

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