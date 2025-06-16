<?php

namespace App\Middleware;

use App\Core\JWT;

class Guest {
    public function handle(): void {
        if (!isset($_COOKIE['token'])) return;

        $jwt = new JWT();
        $payload = $jwt->decode($_COOKIE['token']);

        if ($payload) {
            header("Location: /dashboard");
            exit;
        }
    }
}
