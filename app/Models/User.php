<?php

/**
 * Ova klasa `User` upravlja korisnicima u aplikaciji.
 * Omogućava osnovne CRUD operacije nad `members` tabelom u bazi.
 * Sve metode koriste pripremljene upite, transakcije i izuzetke za sigurnost i stabilnost.
 * @author 
 * @version 1.0.1
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\JWT;
use App\Core\Logger;

class User extends Database
{
    // Konstantna za ime tabele u bazi
    protected const MEMBERS_TABLE = "members";

    public function __construct()
    {
        parent::__construct(); // Poziva konstruktor iz bazne Database klase da bi se uspostavila konekcija
    }

    /**
     * Dohvata jednog korisnika na osnovu ID-a.
     *
     * @param int $id ID korisnika
     * @return array|null Vraća asocijativni niz sa podacima korisnika ili null ako ne postoji
     */
    public function getById(int $id)
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            // Priprema SQL upita
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE . " WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje parametar (int)
            if (!$stmt->bind_param("i", $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            // Izvršava upit
            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            // Dobija rezultat
            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            return $result->fetch_assoc(); // Vraća jednog korisnika kao asocijativni niz
        } catch (\Throwable $e) {
            Logger::error(Logger::translate('users.error_get_by_id', ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara pripremljeni upit
            }
        }
    }

    /**
     * Dohvata korisnika na osnovu korisničkog imena.
     *
     * @param string $username Korisničko ime
     * @return array|null Vraća podatke korisnika ili null
     */
    public function getByUsername(string $username)
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE . " WHERE username = ?");

            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje string parametar
            if (!$stmt->bind_param("s", $username)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            return $result->fetch_assoc();
        } catch (\Throwable $e) {
            Logger::error(Logger::translate('users.error_get_by_username', ['username' => $username, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara pripremljeni upit
            }
        }
    }

    /**
     * Dohvata sve korisnike iz baze.
     *
     * @return array Lista svih korisnika u obliku asocijativnog niza
     */
    public function getAll(): array
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE);

            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC); // Vraća sve redove kao niz asocijativnih nizova
        } catch (\Throwable $e) {
            Logger::error(Logger::translate('users.error_get_all', ['error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Dodaje novog korisnika u bazu.
     *
     * @param string $username Korisničko ime
     * @param string $password Lozinka (plain tekst, biće hashovana)
     * @param int $admin Da li je admin (1 = da, 0 = ne)
     * @return bool True ako je unos uspešan
     */
    public function add(array $data): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $this->conn->begin_transaction(); // Pokreće transakciju

            // Hashuje lozinku radi bezbednosti
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            if (!$hashedPassword) {
                throw new \Exception("Failed to hash password");
            }

            $stmt = $this->conn->prepare("INSERT INTO " . self::MEMBERS_TABLE . " (username, password, admin, aktivan) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje parametre: string, string, int
            if (!$stmt->bind_param("ssii", $data['username'], $hashedPassword, $data['admin'], $data['aktivan'])) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit(); // Potvrđuje transakciju
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('users.error_add', ['username' => $data['username'], 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Briše korisnika na osnovu ID-a.
     *
     * @param int $id ID korisnika koji se briše
     * @return bool True ako je brisanje uspešno
     */
    public function delete(int $id): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("DELETE FROM " . self::MEMBERS_TABLE . " WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("i", $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('users.error_delete', ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Ažurira korisničke podatke u bazi.
     *
     * @param int $id ID korisnika koji se menja
     * @param array $data Asocijativni niz sa novim podacima korisnika
     */
    public function edit(int $id, array $data): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("UPDATE " . self::MEMBERS_TABLE . " SET username = ?, password = ?, admin = ?, aktivan = ? WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje parametre za ažuriranje
            if (!$stmt->bind_param("ssiii", $data['username'], $data['password'], $data['admin'], $data['aktivan'], $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('users.error_edit', ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Ažurira korisničku lozinku u bazi.
     *
     * @param int $id ID korisnika koji se menja
     * @param string $password Nova korisnička lozinka
     */
    public function editPassword(int $id, string $password): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("UPDATE " . self::MEMBERS_TABLE . " SET password = ? WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            if (!$password_hashed) {
                throw new \Exception("Failed to hash the password: " . $this->conn->error);
            }
            if (!$stmt->bind_param("si", $password_hashed, $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('users.error_edit', ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
    /**
     * Proverava da li je korisnik admin.
     *
     * @return bool True ako je korisnik admin
     */
    public function isAdmin(): bool
    {
        try {
            if (!isset($_COOKIE['token'])) return false;
            $token = $_COOKIE['token'];
            $jwt = new JWT();
            $payload = $jwt->decode($token);
            if (!$payload || $payload['admin'] !== 1) return false;

            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error("Error in User->isAdmin method: " . $e->getMessage());
            throw $e; // Prosleđuje izuzetak dalje
        }
    }
}
