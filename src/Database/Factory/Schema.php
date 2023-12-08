<?php

namespace Sienekib\Mehael\Database\Factory;

use PDO;
use PDOException;
use Sienekib\Mehael\Database\Concerns\Connection;

class Schema
{
    public static function create(string $table, string $sql)
    {
        try {
            (new Connection())->getConnection()->exec("CREATE TABLE IF NOT EXISTS $table ($sql)");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function dropIfExists(string $table)
    {
        try {
            (new Connection())->getConnection()->exec("DROP TABLE IF EXISTS $table");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
