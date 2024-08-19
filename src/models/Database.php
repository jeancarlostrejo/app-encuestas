<?php

namespace Ferre\Polls\Models;

use Exception;
use PDO;
use PDOException;

class Database
{
    public function __construct(
        private string $host = "localhost",
        private string $db = "encuestas",
        private string $port = "3308",
        private string $username = "root",
        private string $password = "",
        private string $charset = "utf8mb4") {
    }

    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};";
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];

            $pdo = new PDO($dsn, $this->username, $this->password, $options);

            return $pdo;
        } catch (PDOException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
