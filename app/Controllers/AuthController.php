<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\JWT;
use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;

class AuthController
{
    private $user, $jwt;
    public function __construct()
    {
        $this->user = new User;
        $this->jwt = new JWT;
    }

    public function index()
    {
        return view("index.view.php");
    }

    public function login()
    {

        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);

        $validator = new Validator();
        $username = $validator->validateUsername(trim($data['username']) ?? '');
        $password = $validator->validatePassword($data['password'] ?? '');

        if ($validator->hasErrors()) {
            echo json_encode([
                'success' => false,
                'error' => implode("<br>", $validator->getErrors())
            ]);
            return;
        }

        $user = $this->user->getByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            Logger::error("Pogresna lozinka ili username");
            echo json_encode(['success' => false, 'error' => "Pogresna lozinka ili username"]);
            return;
        }
        $token = $this->jwt->encode([
            'member_id' => $user['member_id'],
            'username' => $user['username'],
            'admin' => $user['admin'],
        ]);

        setcookie('token', $token, [
            'expires' => time() + 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => false,
            'samesite' => 'Lax'
        ]);
        Logger::info("Korisnik {$username} uspesno ulogovan");
        echo json_encode(['success' => true, 'redirect' => '/dashboard']);
    }

    public function logout()
    {
        $token = $_COOKIE['token'];
        setcookie('token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => false,
            'samesite' => 'Lax'
        ]);
        $data = $this->jwt->decode($token);
        Logger::info("Korisnik {$data['username']} uspreno izlogovan");
        echo json_encode(['message' => 'Uspesno izlogovan', 'redirect' => '/']);
    }
}
