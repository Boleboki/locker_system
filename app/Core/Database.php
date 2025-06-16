<?php

namespace App\Core;

class Database {
    protected $conn;
    protected $stmt;

    public function __construct() {
        $this->conn = new \mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            throw new \Exception("Failed to connect to database: " . $this->conn->connect_error, 500);
        }
    }

    public function query($query, $params = []) {
        $this->stmt = $this->conn->prepare($query);
        if (!$this->stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            if (!$this->stmt->bind_param($types, ...$params)) {
                throw new \Exception("Failed to bind parameters: " . $this->stmt->error);
            }
        }

        if (!$this->stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $this->stmt->error);
        }

        return $this;
    }

    public function find() {
        $result = $this->stmt->get_result();
        if (!$result) {
            throw new \Exception("Failed to get result: " . $this->stmt->error);
        }
        return $result->fetch_assoc();
    }

    public function findOrFail() {
        $result = $this->find();
        if (!$result) {
            throw new \Exception("Record not found", 404);
        }
        return $result;
    }

    public function fetch_all() {
        $result = $this->stmt->get_result();
        if (!$result) {
            throw new \Exception("Failed to get result: " . $this->stmt->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function close() {
        if ($this->stmt) {
            $this->stmt->close();
        }
    }
}
