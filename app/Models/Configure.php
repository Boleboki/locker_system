<?php

namespace App\Models;

use App\Core\Database;

class Configure extends Database
{
    protected const CONFIGURATION_TABLE = "confingure";

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::CONFIGURATION_TABLE . " ORDER BY name");
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
        } catch (\Exception $e) {
            throw $e;
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function update(string $key, string $value): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("UPDATE " . self::CONFIGURATION_TABLE . " SET par = ? WHERE name = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("ss", $value, $key)) {
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

    public function delete(string $key): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("DELETE FROM " . self::CONFIGURATION_TABLE . " WHERE name = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("s", $key)) {
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
