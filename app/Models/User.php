<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User extends Database {
    protected string $table = "members";
    public function __construct() {
        parent::__construct();
    }
    public function getById(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE member_id = ?");
        if (!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->bind_param("i", $id)) throw new \Exception("Failed to bind parameters: " . $stmt->error);
        if (!$stmt->execute()) throw new \Exception("Failed to execute statement: " . $stmt->error);
        $result = $stmt->get_result();
        if (!$result) throw new \Exception("Failed to get result: " . $stmt->error);
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result->fetch_assoc();
    }

    public function getByUsername(string $username){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        if (!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->bind_param("s", $username)) throw new \Exception("Failed to bind parameters: " . $stmt->error);
        if (!$stmt->execute()) throw new \Exception("Failed to execute statement: " . $stmt->error);
        $result = $stmt->get_result();
        if (!$result) throw new \Exception("Failed to get result: " . $stmt->error);
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result->fetch_assoc();
        
    }

    public function getAll(): array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
        if(!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->execute()) throw new \Exception("Failed to execute statement: " . $stmt->error);
        $result = $stmt->get_result();
        if (!$result) throw new \Exception("Failed to get result: " . $stmt->error);
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public function add(string $username, string $password, int $admin): bool{
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if(!$hashedPassword) throw new \Exception("Failed to hash password");
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (username, password, admin) VALUES (?, ?, ?)");
        if(!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->bind_param("ssi", $username, $hashedPassword, $admin)) throw new \Exception("Failed to bind parameters: " . $stmt->error);
        $result = $stmt->execute();
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result;
        
    }

    public function delete(int $id): bool{
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE member_id = ?");
        if(!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->bind_param("i", $id)) throw new \Exception("Failed to bind parameters: " . $stmt->error);
        $result = $stmt->execute();
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result;
        
    }

    public function edit(int $id, string $username, string $password, int $admin): bool{
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET username = ?, password = ?, admin = ? WHERE member_id = ?");
        if(!$stmt) throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        if (!$stmt->bind_param("ssii", $username, $password, $admin, $id)) throw new \Exception("Failed to bind parameters: " . $stmt->error);
        $result = $stmt->execute();
        if(!$stmt->close()) throw new \Exception("Failed to close the statement: " . $stmt->error);
        return $result;
    }

}