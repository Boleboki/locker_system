<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    protected const MEMBERS_TABLE = "members";

    public function __construct()
    {
        parent::__construct();
    }

    public function getById(int $id)
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE . " WHERE member_id = ?");
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

            return $result->fetch_assoc();
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function getByUsername(string $username)
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE . " WHERE username = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

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
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function getAll(): array
    {
        $stmt = null;
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . self::MEMBERS_TABLE . "");
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
        } finally {
            if ($stmt) {
                $stmt->close();
            }
        }
    }

    public function add(string $username, string $password, int $admin): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if (!$hashedPassword) {
                throw new \Exception("Failed to hash password");
            }

            $stmt = $this->conn->prepare("INSERT INTO " . self::MEMBERS_TABLE . " (username, password, admin) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

            if (!$stmt->bind_param("ssi", $username, $hashedPassword, $admin)) {
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

    public function edit(int $id, string $username, string $password, int $admin): bool
    {
        $stmt = null;
        try {
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("UPDATE " . self::MEMBERS_TABLE . " SET username = ?, password = ?, admin = ? WHERE member_id = ?");
            if (!$stmt) {
                throw new \Exception("Failed to prepare statement: " . $this->conn->error);
            }

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
