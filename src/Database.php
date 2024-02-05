<?php

namespace Jobtrek\PhpSlimTodo;

use PDO;

class Database
{
    private static null|Database $instance = null;

    private PDO $db;

    private function __construct()
    {
        $dsn = "sqlite:". __DIR__ . '/../database.db';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->db = new PDO($dsn, null, null, $options);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDb(): PDO
    {
        return $this->db;
    }
}
