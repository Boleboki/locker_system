<?php

/**
 * Klasa `Configure` omogućava pristup i upravljanje podešavanjima sistema
 * koja su smeštena u tabeli `confingure` baze podataka.
 * Pruža metode za čitanje svih podešavanja, ažuriranje određenog para ključ/vrednost i brisanje ključa.
 */

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;

class Configure extends Database
{
    // Naziv tabele sa konfiguracionim podacima
    protected const CONFIGURATION_TABLE = "confingure"; // Paziti: "confingure" umesto "configure" (proveriti da li je greška u nazivu)

    public function __construct()
    {
        parent::__construct(); // Uspostavlja konekciju sa bazom koristeći roditeljsku klasu Database
    }

    /**
     * Vraća sve konfiguracione parove iz baze, sortirane po nazivu.
     *
     * @return array Lista konfiguracija kao niz asocijativnih nizova
     */
    public function getAll(): array
    {
        $stmt = null;
        try {
            // Priprema SQL upita za čitanje svih redova iz konfiguracione tabele
            $stmt = $this->conn->prepare("SELECT * FROM " . self::CONFIGURATION_TABLE . " ORDER BY name");
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Izvršava pripremljeni upit
            if (!$stmt->execute()) {
                Logger::error("Failed to execute statement: " . $stmt->error);
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            // Dobija rezultat
            $result = $stmt->get_result();
            if (!$result) {
                Logger::error("Failed to get result: " . $stmt->error);
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            // Vraća sve rezultate kao niz asocijativnih nizova
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Exception $e) {
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara pripremljeni upit
            }
        }
    }

    /**
     * Ažurira vrednost konfiguracionog parametra po ključnoj reči.
     *
     * @param string $key Ključ parametra (kolona `name`)
     * @param string $value Nova vrednost (kolona `par`)
     * @return bool True ako je ažuriranje uspešno
     */
    public function update(string $key, string $value): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction(); // Pokreće SQL transakciju

            // Priprema SQL upit za ažuriranje vrednosti
            $stmt = $this->conn->prepare("UPDATE " . self::CONFIGURATION_TABLE . " SET par = ? WHERE name = ?");
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje vrednosti: nova vrednost i ključ
            if (!$stmt->bind_param("ss", $value, $key)) {
                Logger::error("Failed to bind parameters: " . $stmt->error);
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            // Izvršava upit
            if (!$stmt->execute()) {
                Logger::error("Failed to execute statement: " . $stmt->error);
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit(); // Potvrđuje transakciju
            return true;
        } catch (\Exception $e) {
            $this->conn->rollback(); // Poništava transakciju u slučaju greške
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara upit
            }
        }
    }
    /**
     * Briše konfiguracioni parametar po njegovom ključu (nazivu).
     *
     * @param string $key Ključ parametra koji se briše
     * @return bool True ako je brisanje uspešno
     */
    public function delete(string $key): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            // Priprema SQL upit za brisanje parametra
            $stmt = $this->conn->prepare("DELETE FROM " . self::CONFIGURATION_TABLE . " WHERE name = ?");
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje ključ (string)
            if (!$stmt->bind_param("s", $key)) {
                Logger::error("Failed to bind parameters: " . $stmt->error);
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                Logger::error("Failed to execute statement: " . $stmt->error);
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
