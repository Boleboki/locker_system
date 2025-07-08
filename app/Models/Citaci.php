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
     * Pomoćna metoda za generisanje SQL naredbe za sortiranje rezultata
     * 
     * @param string|null $sort - Kolona po kojoj se sortira (mora biti u listi dozvoljenih kolona)
     * @param string|null $direction - Smer sortiranja: 'asc' ili 'desc'
     * 
     * @return string - Deo SQL upita za sortiranje (npr. "ORDER BY opis_citaca asc") ili prazan string ako nema sortiranja
     * 
     * Ako se traženo polje ne nalazi u listi dozvoljenih kolona ($tableKeys), koristi se podrazumevano prvo polje.
     * Ako je smer neispravan, koristi se 'asc' kao podrazumevani.
     */
    protected function sortQuery(?string $sort = null, ?string $direction = null): string
    {
        if (empty($sort)) return "";
        $allowedDirs = ['asc', 'desc'];

        $sort = !in_array($sort, self::$tableKeys) ? self::$tableKeys[0] : $sort;

        $direction = strtolower($direction);
        $direction = !in_array($direction, $allowedDirs) ? $allowedDirs[0] : $direction;
        return " ORDER BY " . $sort . " " . $direction;
    }
    /**
     * Dohvata sve čitače iz baze uz opciono sortiranje i pretragu
     * 
     * @param string|null $sort - Naziv kolone po kojoj se sortira (mora biti u listi dozvoljenih)
     * @param string|null $direction - Smer sortiranja ('asc' ili 'desc')
     * @param string|null $search - Tekst za pretragu (pretražuje se opis_citaca i sn_citaca)
     * 
     * @return array - Niz svih redova iz tabele 'citaci', kao asocijativni nizovi
     */
    public function getAll(?string $sort = null, ?string $direction = null, ?string $search = null): array
    {
        $stmt = null;
        try {
            $this->ensureConnection();

            $sortPart = $this->sortQuery($sort, $direction);
            $params = [];
            $paramTypes = '';
            $whereClause = '';

            // Lista dozvoljenih polja za pretragu
            $searchableFields = [
                'id_citaca',
                'opis_citaca',
                'sn_citaca',
                'sn_barijere',
                'ip_address'
            ];

            if (!empty($search)) {
                $conditions = [];
                foreach ($searchableFields as $field) {
                    $conditions[] = "$field LIKE ?";
                    $params[] = '%' . $search . '%';
                    $paramTypes .= 's';
                }
                $whereClause = ' WHERE ' . implode(' OR ', $conditions);
            }

            $sql = "SELECT * FROM " . self::TABLE_NAME . $whereClause . $sortPart;

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($paramTypes, ...$params);
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
