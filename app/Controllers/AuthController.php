<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\JWT as JWTAuth;
use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;

/**
 * Kontroler za autentifikaciju korisnika.
 * Omogućava prijavu (login), odjavu (logout) i prikaz početne stranice.
 * Rukuje validacijom korisničkih podataka, kreiranjem JWT tokena i upravlja kolačićima sesije.
 */
class AuthController
{
    private $user, $jwt;

    /**
     * Konstruktor koji inicijalizuje User model i JWT servis.
     */
    public function __construct()
    {
        $this->user = new User;
        $this->jwt = new JWTAuth;
    }

    /**
     * Prikazuje početnu stranicu (login formu).
     * Ne prima parametre.
     * Vraća prikaz view fajla.
     */
    public function index()
    {
        try {
            return view("index.view.php");
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Obrađuje login zahtev.
     * Ne prima parametre, podatke čita iz JSON payload-a POST zahteva.
     * Validira username i password, proverava korisnika u bazi, kreira JWT token,
     * postavlja HTTP-only kolačić i vraća JSON odgovor o uspehu ili grešci.
     */
    public function login()
    {
        // Čitanje sirovog JSON inputa iz tela zahteva
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);

        // Validacija unetih podataka
        $validator = new Validator();
        $username = $validator->validateUsername(trim($data['username']) ?? '');
        $password = $validator->validatePassword($data['password'] ?? '');

        // Ako postoje greške u validaciji, vraćaju se kao JSON odgovor
        if ($validator->hasErrors()) {
            echo json_encode([
                'success' => false,
                'error' => $validator->getErrors()
            ]);
            return;
        }

        // Dohvata korisnika iz baze po username-u
        $user = $this->user->getByUsername($username);

        // Provera da li korisnik postoji i da li lozinka odgovara
        if (!$user || !password_verify($password, $user['password'])) {
            Logger::error("Pogresna lozinka ili username");
            echo json_encode(['success' => false, 'error' => "Pogrešna lozinka ili username"]);
            return;
        }

        // Kreiranje JWT tokena sa korisničkim informacijama
        $token = $this->jwt->encode([
            'member_id' => $user['member_id'],
            'username' => $user['username'],
            'admin' => $user['admin'],
        ]);

        // Postavljanje kolačića sa tokenom - HTTP only, važan za sigurnost
        setcookie('token', $token, [
            'expires' => time() + 3600, // token važi 1 sat
            'path' => '/',
            'httponly' => true, // sprečava pristup kolačiću iz JavaScript-a
            'secure' => false, // u produkciji treba true ako je HTTPS
            'samesite' => 'Lax' // smanjuje rizik od CSRF napada
        ]);

        Logger::info("Korisnik {$username} uspesno ulogovan");

        // Uspešan JSON odgovor sa redirekcijom
        echo json_encode(['success' => true, 'redirect' => url('/dashboard')]);
    }

    /**
     * Odjavljuje korisnika.
     * Briše kolačić sa JWT tokenom tako što postavlja vreme isteka u prošlost.
     * Dekodira token radi logovanja korisničkog imena za evidenciju.
     * Vraća JSON odgovor o uspešnoj odjavi i redirekciji.
     */
    public function logout()
    {
        $token = $_COOKIE['token'] ?? '';

        // Brisanje kolačića sa tokenom - isticanje u prošlosti
        setcookie('token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => false,
            'samesite' => 'Lax'
        ]);

        // Dekodiranje tokena za pristup korisničkim podacima
        $data = $this->jwt->decode($token);

        Logger::info("Korisnik {$data['username']} uspreno izlogovan");

        echo json_encode(['message' => 'Uspesno izlogovan', 'redirect' => url('/')]);
    }
}
