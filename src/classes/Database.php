<?php

namespace App\classes;

use PDO;
//use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . "/../config/database.php";

        $dsn = "mysql:host={$config["host"]};dbname={$config["dbname"]};charset={$config["charset"]}";
        $this->pdo = new PDO($dsn, $config["username"], $config["password"], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
