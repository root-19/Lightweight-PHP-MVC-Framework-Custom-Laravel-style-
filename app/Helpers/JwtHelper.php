<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private static function getConfig()
    {
        return require __DIR__ . '/../../config/config.php';
    }

    public static function generateToken(array $payload): string
    {
        $config = self::getConfig();
        $issuedAt = time();
        $expiration = $issuedAt + $config['jwt']['expiration'];

        $tokenPayload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expiration,
        ]);

        return JWT::encode($tokenPayload, $config['jwt']['secret'], 'HS256');
    }

    public static function validateToken(string $token): ?array
    {
        try {
            $config = self::getConfig();
            $decoded = JWT::decode($token, new Key($config['jwt']['secret'], 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
} 