<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;

/**
 * Model za rad sa tabelom 'citaci' u bazi podataka
 * Ova klasa omogućava CRUD operacije nad tabelom citaci
 * Nasleđuje baznu klasu Database kako bi koristila konekciju ka MySQL bazi
 * @author 
 * @version 1.0.1
 */

class Citaci extends Database
{
    private const TABLE_NAME = 'citaci';
    /**
     * Konstruktor klase Citaci
     * Inicijalizuje konekciju sa bazom koristeći roditeljsku klasu
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista svih kolona (ključeva) koje se koriste u tabeli 'citaci'
     * 
     * Koristi se za:
     * - validaciju podataka prilikom unosa i ažuriranja (provera da li svi ključni elementi postoje)
     * - definisanje dozvoljenih kolona za sortiranje
     */
    private static array $tableKeys = [
        'id_citaca',
        'opis_citaca',
        'tip_citaca',
        'aktivan',
        'citac_za_radno_vreme',
        'citac_za_kontrolu_pristupa',
        'citac_za_ormarice',
        'citac_za_grupu_ormarica',
        'citac_za_odjavu',
        'delay',
        'delay_senzora',
        'sn_citaca',
        'sn_barijere',
        'broj_ormarica',
        'broj_redova_ormarica',
        'brojevi_ormarica_po_indexu',
        'ip_address'
    ];

    /**
     * Dohvata sve čitače iz baze uz opciono sortiranje i pretragu
     * 
     * @return array - Niz svih redova iz tabele 'citaci', kao asocijativni nizovi
     */
    public function getAll(): array
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $sql = "SELECT * FROM " . self::TABLE_NAME;

            $stmt = $this->conn->prepare($sql);
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

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_get_all", ['error' => $e->getMessage()]));
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Dohvata jednog čitača na osnovu ID-ja
     * @param int $id - ID čitača
     * @return array|null - Vraća podatke čitača kao asocijativni niz ili null ako ne postoji
     */
    public function getById(int $id): ?array
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $stmt = $this->conn->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE id_citaca = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("i", $id)) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            return $result->fetch_assoc() ?: null; // Vraća asocijativni niz ili null ako nije pronađeno
        } catch (\Throwable $e) {
            Logger::error(Logger::translate("logs.citaci.error_get_by_id", ['id' => $id, 'error' => $stmt->error]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara pripremljeni upit
            }
        }
    }

    /**
     * Ubacuje novi čitač u bazu
     * @param array $data - Asocijativni niz sa podacima o čitaču
     * @return bool - True ako je unos uspešan
     */
    public function create(array $data): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $this->conn->begin_transaction();

            $sql = "INSERT INTO " . self::TABLE_NAME . " (
            id_citaca,
            opis_citaca,
            tip_citaca,
            citac_za_radno_vreme,
            citac_za_kontrolu_pristupa,
            citac_za_ormarice,
            citac_za_grupu_ormarica,
            citac_za_odjavu,
            delay,
            sn_citaca,
            sn_barijere,
            delay_senzora,
            broj_ormarica,
            broj_redova_ormarica,
            brojevi_ormarica,
            aktivan,
            brojevi_ormarica_po_indexu,
            ip_address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Provera da li su svi potrebni ključevi u $data

            foreach (self::$tableKeys as $key) {
                if (!array_key_exists($key, $data)) {
                    Logger::error(Logger::translate("logs.citaci.missing_field", ['field' => $key]));
                    throw new \Exception("Missing required data field: $key");
                }
            }

            $bind = $stmt->bind_param(
                "isssssssiisiiisiis",
                $data['id_citaca'],
                $data['opis_citaca'],
                $data['tip_citaca'],
                $data['citac_za_radno_vreme'],
                $data['citac_za_kontrolu_pristupa'],
                $data['citac_za_ormarice'],
                $data['citac_za_grupu_ormarica'],
                $data['citac_za_odjavu'],
                $data['delay'],
                $data['sn_citaca'],
                $data['sn_barijere'],
                $data['delay_senzora'],
                $data['broj_ormarica'],
                $data['broj_redova_ormarica'],
                $data['brojevi_ormarica'],
                $data['aktivan'],
                $data['brojevi_ormarica_po_indexu'],
                $data['ip_address']
            );

            if (!$bind) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $this->conn->commit();

            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate("logs.citaci.error_create", ['error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Ažurira postojeći čitač u bazi
     * @param int $id - ID čitača koji se ažurira
     * @param array $data - Podaci koji treba da se ažuriraju
     * @return bool - True ako je uspešno ažurirano
     */
    public function update(int $id, array $data): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $this->conn->begin_transaction();

            $sql = "UPDATE " . self::TABLE_NAME . " SET
            id_citaca = ?,
            opis_citaca = ?,
            tip_citaca = ?,
            citac_za_radno_vreme = ?,
            citac_za_kontrolu_pristupa = ?,
            citac_za_ormarice = ?,
            citac_za_grupu_ormarica = ?,
            citac_za_odjavu = ?,
            delay = ?,
            sn_citaca = ?,
            sn_barijere = ?,
            delay_senzora = ?,
            broj_ormarica = ?,
            broj_redova_ormarica = ?,
            brojevi_ormarica = ?,
            aktivan = ?,
            brojevi_ormarica_po_indexu = ?,
            ip_address = ?
        WHERE id_citaca = ?";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            foreach (self::$tableKeys as $key) {
                if (!array_key_exists($key, $data)) {
                    Logger::error(Logger::translate("logs.citaci.missing_field", ['field' => $key]));
                    throw new \Exception("Missing required data field: $key");
                }
            }

            if (!$stmt->bind_param(
                "isssssssiisiiisiisi",
                $data["id_citaca"],
                $data['opis_citaca'],
                $data['tip_citaca'],
                $data['citac_za_radno_vreme'],
                $data['citac_za_kontrolu_pristupa'],
                $data['citac_za_ormarice'],
                $data['citac_za_grupu_ormarica'],
                $data['citac_za_odjavu'],
                $data['delay'],
                $data['sn_citaca'],
                $data['sn_barijere'],
                $data['delay_senzora'],
                $data['broj_ormarica'],
                $data['broj_redova_ormarica'],
                $data['brojevi_ormarica'],
                $data['aktivan'],
                $data['brojevi_ormarica_po_indexu'],
                $data['ip_address'],
                $id
            )) {
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Failed to execute update statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollback();
            Logger::error(Logger::translate("logs.citaci.error_update", ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Briše čitač iz baze na osnovu ID-ja
     * @param int $id - ID čitača koji se briše
     * @return bool - True ako je uspešno obrisano
     */
    public function delete(int $id): bool
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $this->conn->begin_transaction();

            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id_citaca = ?";
            $stmt = $this->conn->prepare($sql);
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
            Logger::error(Logger::translate("logs.citaci.error_delete", ['id' => $id, 'error' => $e->getMessage()]));
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
