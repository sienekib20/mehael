<?php

namespace Sienekib\Mehael\Database\Concerns;

use PDO;
use PDOException;

class Connection
{
    private ?PDO $connection = null;

    public function initDBConnection()
    {
        try {
            if (!($this->connection = new PDO(
                "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE', 'master'),
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            ))) {
                throw new \Exception('Connection error');
            }
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        if (is_null($this->connection)) {
            $this->initDBConnection();
        }
        return $this->connection;
    }
}
