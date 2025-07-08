<?php

/**
 * Klasa `Configure` omogućava pristup i upravljanje podešavanjima sistema
 * koja su smeštena u tabeli `confingure` baze podataka.
 * Pruža metode za čitanje svih podešavanja, ažuriranje određenog para ključ/vrednost i brisanje ključa.
 * @author 
 * @version 1.0.1
 */

namespace App\Models;

use App\Core\Database;
use App\Core\Lang;
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
     * Vraća sve konfiguracione parove iz baze, sa prevodima ako postoje.
     * 
     * @param string|null $lang - Jezik za prevod opisa konfiguracija (ako nije prosleđen koristi se trenutno aktivni jezik)
     * 
     * @return array - Niz svih konfiguracija u formatu: [name, par, opis, tip]
     * 
     * Izvodi SQL upit koji spaja osnovnu konfiguracionu tabelu sa tabelom prevoda
     * i vraća rezultate kao niz asocijativnih nizova. Ako dođe do greške, loguje je i prosleđuje dalje.
     */
    public function getAll(?string $lang = null): array
    {
        $stmt = null;
        try {
            $lang = $lang ?? Lang::getLocale();
            $this->ensureConnection();
            // Priprema SQL upita za čitanje svih redova iz konfiguracione tabele
            $query = "
                SELECT c.name as name, c.par as par, t.description as opis, c.tip as tip
                FROM " . self::CONFIGURATION_TABLE . " c
                LEFT JOIN configuration_translations t 
                    ON c.name = t.configuration_name AND t.language = ?
                ORDER BY c.name
            ";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }
            $stmt->bind_param("s", $lang);

            // Izvršava pripremljeni upit
            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            // Dobija rezultat
            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            // Vraća sve rezultate kao niz asocijativnih nizova
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate('logs.configuration.error_get_all', ['error' => $e->getMessage()]));
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
            $this->ensureConnection();
            $this->conn->begin_transaction(); // Pokreće SQL transakciju

            // Priprema SQL upit za ažuriranje vrednosti
            $stmt = $this->conn->prepare("UPDATE " . self::CONFIGURATION_TABLE . " SET par = ? WHERE name = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje vrednosti: nova vrednost i ključ
            if (!$stmt->bind_param("ss", $value, $key)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            // Izvršava upit
            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit(); // Potvrđuje transakciju
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('logs.configuration.error_update', ['key' => $key, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
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
            $this->ensureConnection();
            $this->conn->begin_transaction();

            // Priprema SQL upit za brisanje parametra
            $stmt = $this->conn->prepare("DELETE FROM " . self::CONFIGURATION_TABLE . " WHERE name = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Vezuje ključ (string)
            if (!$stmt->bind_param("s", $key)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate('logs.configuration.error_delete', ['key' => $key, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
