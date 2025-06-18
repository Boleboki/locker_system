<?php

/**
 * Ova klasa `User` upravlja korisnicima u aplikaciji.
 * Omogućava osnovne CRUD operacije nad `members` tabelom u bazi.
 * Sve metode koriste pripremljene upite, transakcije i izuzetke za sigurnost i stabilnost.
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
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
        } catch (\Exception $e) {
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
    public function add(string $username, string $password, int $admin): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction(); // Pokreće transakciju

            // Hashuje lozinku radi bezbednosti
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if (!$hashedPassword) {
                throw new \Exception("Failed to hash password");
            }

            $stmt = $this->conn->prepare("INSERT INTO " . self::MEMBERS_TABLE . " (username, password, admin) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje parametre: string, string, int
            if (!$stmt->bind_param("ssi", $username, $hashedPassword, $admin)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit(); // Potvrđuje transakciju
            return true;
        } catch (\Exception $e) {
            $this->conn->rollback(); // Vraća sve ako nešto pođe po zlu
            throw $e;
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
        } catch (\Exception $e) {
            $this->conn->rollback();
            throw $e;
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
     * @param string $username Novo korisničko ime
     * @param string $password Nova lozinka (već hashovana ili plain)
     * @param int $admin Admin status (1 = admin, 0 = običan korisnik)
     * @return bool True ako je uspešno ažuriranje
     */
    public function edit(int $id, string $username, string $password, int $admin): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("UPDATE " . self::MEMBERS_TABLE . " SET username = ?, password = ?, admin = ? WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje parametre za ažuriranje
            if (!$stmt->bind_param("ssii", $username, $password, $admin, $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollback();
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
