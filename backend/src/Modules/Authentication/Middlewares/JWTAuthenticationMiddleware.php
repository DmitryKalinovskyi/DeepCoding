<?php

namespace DeepCode\Modules\Authentication\Middlewares;

use DeepCode\Modules\Authentication\Services\IJWTService;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\Http\HttpContext;

class JWTAuthenticationMiddleware
{
    private const AUTH_SCHEME = "Bearer";

    public function __invoke(HttpContext $context, IJWTService $jwtService, IUserRepository $userRepository, $next): void{
        // this is simple workaround for time

        // read bearer token from headers
        $headers = getallheaders();

        // there are no authorization header
        if(empty($headers['Authorization'])){
            $next();
            return;
        }

        if(!str_starts_with($headers['Authorization'], self::AUTH_SCHEME)){
            $next();
            return;
        }

        $token = explode(" ", $headers['Authorization'])[1];

        if(!$jwtService->isTokenValid( $token)){
            $next();
            return;
        }

        $userLogin = $jwtService->parseToken($token);

        $context->user = $userRepository->findByLogin($userLogin);

        $next();
    }
}