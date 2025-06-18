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
 */
class UserController
{
    private User $user;

    public function __construct()
    {
        // Inicijalizuje model korisnika za rad sa bazom
        $this->user = new User();
    }

    /**
     * Prikazuje listu svih korisnika.
     *
     */
    public function index()
    {
        $users = $this->user->getAll();

        return view("users/index.view.php", [
            "users" => $users
        ]);
    }

    /**
     * Prikazuje formu za kreiranje novog korisnika.
     *
     */
    public function create()
    {
        return view("users/create.view.php");
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
            $isAdmin = isset($data['isAdmin']) ? (int)$data['isAdmin'] : 0;

            if ($validator->hasErrors()) {
                // Vraća greške kao JSON odgovor
                echo json_encode([
                    'success' => false,
                    'error' => implode("\n", $validator->getErrors())
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

            // Dodavanje korisnika u bazu
            if (!$this->user->add($username, $password, $isAdmin)) {
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
        } catch (Exception $e) {
            // Server error
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Došlo je do greške: " . $e->getMessage()
            ]);
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
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Došlo je do greške: " . $e->getMessage()
            ]);
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
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Došlo je do greške: " . $e->getMessage()
            ]);
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

            if (!$input || !isset($input["username"], $input["isAdmin"])) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Neispravan unos podataka.'
                ]);
                return;
            }

            $validator = new Validator();

            $username = $validator->validateUsername($input['username'] ?? '');
            $password = $input['password'] ?? '';

            if (!empty($password)) {
                $password = $validator->validatePassword($password);
            }

            $isAdmin = (int)$input["isAdmin"];

            $currentUser = $this->user->getById($id);
            $existingUser = $this->user->getByUsername($username);

            // Provera da li korisničko ime već postoji i nije trenutni korisnik
            if ($existingUser && (int)$existingUser["member_id"] !== $id) {
                $validator->addError("Korisničko ime već postoji.");
            }

            if ($validator->hasErrors()) {
                echo json_encode([
                    'success' => false,
                    'error' => implode("<br>", $validator->getErrors())
                ]);
                return;
            }

            // Ako nova lozinka nije prosleđena, koristi postojeću iz baze
            $passwordHash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $currentUser["password"];

            $result = $this->user->edit($id, $username, $passwordHash, $isAdmin);

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
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Došlo je do greške: " . $e->getMessage()
            ]);
        }
    }
}
