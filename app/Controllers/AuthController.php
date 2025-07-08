<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\JWT as JWTAuth;
use App\Core\Lang;
use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;
use Respect\Validation\Validator as v;

/**
 * Kontroler za autentifikaciju korisnika.
 * Omogućava prijavu (login), odjavu (logout) i prikaz početne stranice.
 * Rukuje validacijom korisničkih podataka, kreiranjem JWT tokena i upravlja kolačićima sesije.
 * 
 * @author 
 * @version 1.0.1
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

    public function __destruct()
    {
        $this->user->disconnect();
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
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.auth.error_show_index", ["error" => $e->getMessage()]));
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Parsira JSON podatke iz HTTP tela zahteva
     * 
     * @return array|null - Vraća podatke kao asocijativni niz ako su validni, u suprotnom baca izuzetak
     * 
     * Čita raw JSON iz ulaza (`php://input`) i dekodira ga.
     * Ako JSON nije validan ili nije niz, loguje upozorenje i baca izuzetak sa prevedenom porukom.
     */
    private function data(): ?array
    {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Logger::warning(Logger::translate("logs.general.invalid_data"));
            throw new \Exception(Lang::get("logs.general.invalid_data"));
        }

        return $data;
    }

    /**
     * Obrađuje login zahtev.
     * Ne prima parametre, podatke čita iz JSON payload-a POST zahteva.
     * Validira username i password, proverava korisnika u bazi, kreira JWT token,
     * postavlja HTTP-only kolačić i vraća JSON odgovor o uspehu ili grešci.
     */
    public function login()
    {
        try {
            // Čitanje sirovog JSON inputa iz tela zahteva
            $data = $this->data();

            // Validacija unetih podataka
            $validator = new Validator();
            $validator->validate($data, [
                'username' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20)),
                'password' => v::notEmpty()->addRule($validator->noSpecialChars())->addRule(v::length(3, 20))
            ]);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            // Ako postoje greške u validaciji, vraćaju se kao JSON odgovor
            if ($validator->hasErrors()) {
                // Logovanje validacionih grešaka za pregled kasnije

                Logger::warning(Logger::translate('logs.auth.validation_failed', ['username' => $username, 'errors' => json_encode($validator->getErrors())]));

                echo json_encode([
                    'success' => false,
                    'errors' => $validator->getErrors()
                ]);
                return;
            }

            // Dohvata korisnika iz baze po username-u
            $user = $this->user->getByUsername($username);

            // Provera da li korisnik postoji i da li lozinka odgovara
            if (!$user || !password_verify($password, $user['password'])) {
                // Logovanje neuspešnog pokušaja prijave
                Logger::error(Logger::translate('logs.auth.login_failed', ['username' => $username]));

                echo json_encode(['success' => false, 'error' => Lang::get("responses.auth.invalid_credentials")]);
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
                'expires' => time() + 3600,
                'path' => '/',
                'httponly' => true,
                'secure' => false,
                'samesite' => 'Lax'
            ]);

            // Logovanje uspešne prijave korisnika
            Logger::info(Logger::translate('logs.auth.login_success', ['username' => $username]));

            // Uspešan JSON odgovor sa redirekcijom
            echo json_encode(['success' => true, 'redirect' => url('/dashboard')]);
        } catch (\Throwable $error) {
            Logger::error(Logger::translate('logs.auth.error_login', ["error" => $error->getMessage()]));
            http_response_code(500);
            echo json_encode($error->getMessage());
        }
    }

    /**
     * Odjavljuje korisnika.
     * Briše kolačić sa JWT tokenom tako što postavlja vreme isteka u prošlost.
     * Dekodira token radi logovanja korisničkog imena za evidenciju.
     * Vraća JSON odgovor o uspešnoj odjavi i redirekciji.
     */
    public function logout()
    {
        try {
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

            // Logovanje informacije o odjavi korisnika
            Logger::info(Logger::translate('logs.auth.logout_success', ['username' => $data['username']]));

            echo json_encode(['message' => Lang::get("responses.auth.logout_success"), 'redirect' => url('/')]);
        } catch (\Throwable $error) {
            Logger::error(Logger::translate("logs.auth.error_logout", ["error" => $error->getMessage()]));
            http_response_code(500);
            echo json_encode($error->getMessage());
        }
    }
}
