<?php
declare(strict_types=1);

namespace App\Core;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Exception;

class JWT {
    private string $key;
    private int $expiration;

    public function __construct(int $expiration = 3600) {
        $this->key = TOKEN;
        $this->expiration = $expiration;
    }

    public function encode(array $data): string {
        $payload = [
            'iat' => time(),
            'exp' => time() + $this->expiration,
            'data' => $data,
        ];

        return FirebaseJWT::encode($payload, $this->key, 'HS256');
    }

    public function decode(string $jwt): ?array {
        try {
            $decoded = FirebaseJWT::decode($jwt, new Key($this->key, 'HS256'));
            return (array) $decoded->data;
        } catch (Exception $e) {
            Logger::error("Greska JWT klasa: " . $e->getMessage());
            return null;
        }
    }
}
