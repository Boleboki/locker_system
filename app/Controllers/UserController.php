<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Logger;
use App\Core\Validator;
use App\Models\User;
use Exception;

/**
 * Kontroler za upravljanje korisnicima.
 * Obezbeđuje CRUD funkcionalnosti i validaciju podataka korisnika.
 *
 * @author 
 * @version 1.0.1
 */
class UserController
{
    private User $user;

    public function __construct()
    {
        // Inicijalizuje model korisnika za rad sa bazom
        $this->user = new User();
    }

    public function __destruct()
    {
        $this->user->disconnect();
    }

    /**
     * Prikazuje listu svih korisnika.
     *
     */
    public function index()
    {
        try {
            return view("users/index.view.php", [
                "users" => $this->user->getAll()
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Prikazuje formu za kreiranje novog korisnika.
     *
     */
    public function create()
    {
        try {
            return view("users/create.view.php");
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Obrada POST zahteva za dodavanje novog korisnika.
     * Validira podatke, proverava postojanje korisnika i upisuje novog korisnika.
     */
    public function store(): void
    {
        try {
            $rawInput = file_get_contents("php://input");
            $data = json_decode($rawInput, true);

            $validator = new Validator();

            $username = $validator->validateUsername($data['username'] ?? '');
            $password = $validator->validatePassword($data['password'] ?? '');

            if ($validator->hasErrors()) {
                // Vraća greške kao JSON odgovor
                echo json_encode([
                    'success' => false,
                    'error' => $validator->getErrors()
                ]);
                return;
            }

            // Provera da li korisnik već postoji u bazi
            if ($this->user->getByUsername($username)) {
                Logger::error("Pokušaj dodavanja već postojećeg korisnika: {$username}");
                echo json_encode([
                    "success" => false,
                    "error" => "Korisnik već postoji"
                ]);
                return;
            }
            $data = [
                'username' => $username,
                'password' => $password,
                'admin' => $data['admin'],
                'aktivan' => $data['aktivan']
            ];
            // Dodavanje korisnika u bazu
            if (!$this->user->add($data)) {
                Logger::error("Greška prilikom dodavanja korisnika: {$username}");
                echo json_encode([
                    "success" => false,
                    "error" => "Korisnik nije dodat"
                ]);
                return;
            }

            Logger::info("Korisnik {$username} uspešno dodat");
            echo json_encode([
                "success" => true,
                "message" => "Korisnik uspešno dodat"
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Briše korisnika po ID-u.
     *
     * @param int $id ID korisnika za brisanje
     */
    public function delete(int $id): void
    {
        try {
            $user = $this->user->getById($id);
            $username = $user['username'] ?? '';

            if (!$username) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "error" => "Korisnik nije pronađen"
                ]);
                return;
            }

            if (!$this->user->delete($id)) {
                Logger::error("Neuspešno brisanje korisnika {$username}");
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "error" => "Brisanje korisnika nije uspelo"
                ]);
                return;
            }

            Logger::info("Korisnik {$username} uspešno obrisan");
            echo json_encode([
                "success" => true,
                "message" => "Korisnik je obrisan"
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Prikazuje formu za izmenu korisnika.
     *
     * @param int $id ID korisnika za izmenu
     */
    public function edit(int $id)
    {
        try {
            $user = $this->user->getById($id);

            if (!$user) {
                Logger::error("Pokušaj izmene nepostojećeg korisnika sa ID: {$id}");
                header("Location: /users");
                exit;
            }

            return view("users/edit.view.php", [
                "user" => $user
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }

    /**
     * Ažurira korisnika na osnovu ID-a.
     *
     * @param int $id ID korisnika
     */
    public function update(int $id): void
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            if (!$input || !isset($input["username"], $input["admin"])) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Neispravan unos podataka.'
                ]);
                return;
            }

            $validator = new Validator();

            $username = $validator->validateUsername($input['username']) ?? '';
            $password = $input['password'] ?? '';

            if (!empty($password)) {
                $password = $validator->validatePassword($password) ?? '';
            }

            $currentUser = $this->user->getById($id);
            $existingUser = $this->user->getByUsername($username);

            // Provera da li korisničko ime već postoji i nije trenutni korisnik
            if ($existingUser && (int)$existingUser["member_id"] !== $id) {
                $validator->addError("Korisničko ime već postoji.");
            }

            if ($validator->hasErrors()) {
                echo json_encode([
                    'success' => false,
                    'error' => $validator->getErrors()
                ]);
                return;
            }

            // Ako nova lozinka nije prosleđena, koristi postojeću iz baze
            $passwordHash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $currentUser["password"];
            $data = [
                'username' => $username,
                'password' => $passwordHash,
                'admin'  => $input["admin"],
                'aktivan' => $input["aktivan"]
            ];
            $result = $this->user->edit($id, $data);

            if ($result) {
                Logger::info("Korisnik {$username} uspešno izmenjen");
                echo json_encode([
                    "success" => true,
                    "message" => "Korisnik uspešno izmenjen"
                ]);
            } else {
                Logger::error("Neuspešna izmena korisnika {$username}");
                echo json_encode([
                    "success" => false,
                    "error" => "Korisnik nije izmenjen"
                ]);
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
        }
    }
}
