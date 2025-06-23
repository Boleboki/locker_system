<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;

/**
 * Model za rad sa tabelom 'citaci' u bazi podataka
 * Ova klasa omogućava CRUD operacije nad tabelom citaci
 * Nasleđuje baznu klasu Database kako bi koristila konekciju ka MySQL bazi
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
     * Dohvata sve čitače iz baze
     * @return array - niz svih redova iz tabele 'citaci'
     */
    public function getAll(): array
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::TABLE_NAME);
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->execute()) {
                Logger::error("Failed to execute statement: " . $stmt->error);
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                Logger::error("Failed to get result: " . $stmt->error);
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

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
     * Dohvata jednog čitača na osnovu ID-ja
     * @param int $id - ID čitača
     * @return array|null - Vraća podatke čitača kao asocijativni niz ili null ako ne postoji
     */
    public function getById(int $id): ?array
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE id_citaca = ?");
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("i", $id)) {
                Logger::error("Failed to bind parameters: " . $stmt->error);
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                Logger::error("Failed to execute statement: " . $stmt->error);
                throw new \Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                Logger::error("Failed to get result: " . $stmt->error);
                throw new \Exception("Failed to get result: " . $stmt->error);
            }

            return $result->fetch_assoc() ?: null; // Vraća asocijativni niz ili null ako nije pronađeno
        } catch (\Exception $e) {
            throw $e; // Prosleđuje izuzetak dalje
        } finally {
            if ($stmt) {
                $stmt->close(); // Zatvara pripremljeni upit
            }
        }
    }

    /**
     * Ubacuje novog čitača u bazu
     * @param array $data - Asocijativni niz sa podacima o čitaču
     * @return bool - True ako je unos uspešan
     * @throws \Exception - Ako dođe do greške u pripremi, bindovanju ili izvršavanju
     */
    public function create(array $data): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $sql = "INSERT INTO " . self::TABLE_NAME . " (
            id_citaca,
            opis_citaca,
            tip_citaca,
            citac_za_formiranje,
            citac_za_radno_vreme,
            citac_za_kontrolu_pristupa,
            citac_za_evidenciju_rada_na_masinama,
            citac_za_el_energiju,
            citac_za_kontrolu_vode,
            citac_za_menzu,
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
            brojevi_ormarica_po_indexu
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Provera da li su svi potrebni ključevi u $data
            $requiredKeys = [
                'id_citaca',
                'opis_citaca',
                'tip_citaca',
                'citac_za_formiranje',
                'citac_za_radno_vreme',
                'citac_za_kontrolu_pristupa',
                'citac_za_evidenciju_rada_na_masinama',
                'citac_za_el_energiju',
                'citac_za_kontrolu_vode',
                'citac_za_menzu',
                'citac_za_ormarice',
                'citac_za_grupu_ormarica',
                'citac_za_odjavu',
                'delay',
                'sn_citaca',
                'sn_barijere',
                'delay_senzora',
                'broj_ormarica',
                'broj_redova_ormarica',
                'brojevi_ormarica',
                'aktivan',
                'brojevi_ormarica_po_indexu'
            ];
            foreach ($requiredKeys as $key) {
                if (!array_key_exists($key, $data)) {
                    Logger::error("Missing required data field: $key");
                    throw new \Exception("Missing required data field: $key");
                }
            }

            $bind = $stmt->bind_param(
                "issssssssssssiisiiisii",
                $data['id_citaca'],
                $data['opis_citaca'],
                $data['tip_citaca'],
                $data['citac_za_formiranje'],
                $data['citac_za_radno_vreme'],
                $data['citac_za_kontrolu_pristupa'],
                $data['citac_za_evidenciju_rada_na_masinama'],
                $data['citac_za_el_energiju'],
                $data['citac_za_kontrolu_vode'],
                $data['citac_za_menzu'],
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
                $data['brojevi_ormarica_po_indexu']
            );

            if (!$bind) {
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
            Logger::error("Error in create method: " . $e->getMessage());
            $this->conn->rollback();
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Ažurira postojećeg čitača u bazi
     * @param int $id - ID čitača koji se ažurira
     * @param array $data - Podaci koji treba da se ažuriraju
     * @return bool - True ako je uspešno ažurirano
     */
    public function update(int $id, array $data): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $sql = "UPDATE " . self::TABLE_NAME . " SET
            id_citaca = ?,
            opis_citaca = ?,
            tip_citaca = ?,
            citac_za_formiranje = ?,
            citac_za_radno_vreme = ?,
            citac_za_kontrolu_pristupa = ?,
            citac_za_evidenciju_rada_na_masinama = ?,
            citac_za_el_energiju = ?,
            citac_za_kontrolu_vode = ?,
            citac_za_menzu = ?,
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
            brojevi_ormarica_po_indexu = ?
        WHERE id_citaca = ?";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            $requiredKeys = [
                'id_citaca',
                'opis_citaca',
                'tip_citaca',
                'citac_za_formiranje',
                'citac_za_radno_vreme',
                'citac_za_kontrolu_pristupa',
                'citac_za_evidenciju_rada_na_masinama',
                'citac_za_el_energiju',
                'citac_za_kontrolu_vode',
                'citac_za_menzu',
                'citac_za_ormarice',
                'citac_za_grupu_ormarica',
                'citac_za_odjavu',
                'delay',
                'sn_citaca',
                'sn_barijere',
                'delay_senzora',
                'broj_ormarica',
                'broj_redova_ormarica',
                'brojevi_ormarica',
                'aktivan',
                'brojevi_ormarica_po_indexu'
            ];
            foreach ($requiredKeys as $key) {
                if (!array_key_exists($key, $data)) {
                    Logger::error("Missing required data field: $key");
                    throw new \Exception("Missing required data field: $key");
                }
            }
            $bind = $stmt->bind_param(
                "issssssssssssiisiiisiii",
                $data["id_citaca"],
                $data['opis_citaca'],
                $data['tip_citaca'],
                $data['citac_za_formiranje'],
                $data['citac_za_radno_vreme'],
                $data['citac_za_kontrolu_pristupa'],
                $data['citac_za_evidenciju_rada_na_masinama'],
                $data['citac_za_el_energiju'],
                $data['citac_za_kontrolu_vode'],
                $data['citac_za_menzu'],
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
                $id
            );

            if (!$bind) {
                Logger::error("Failed to bind parameters: " . $stmt->error);
                throw new \Exception("Failed to bind parameters: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                Logger::error("Failed to execute update statement: " . $stmt->error);
                throw new \Exception("Failed to execute update statement: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            Logger::error("Error in update method: " . $e->getMessage());
            $this->conn->rollback();
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    /**
     * Briše čitača iz baze na osnovu ID-ja
     * @param int $id - ID čitača koji se briše
     * @return bool - True ako je uspešno obrisano
     */
    public function delete(int $id): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id_citaca = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                Logger::error("Failed to prepare statement: " . $this->conn->error);
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("i", $id)) {
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
            Logger::error("Error in delete method: " . $e->getMessage());
            $this->conn->rollback();
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
