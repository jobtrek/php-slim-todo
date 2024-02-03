<?php

namespace Jobtrek\PhpSlimTodo;

use PDO;

class Database
{
    public static function getDatabaseConnection(string $path): PDO
    {
        $dsn = "sqlite:$path";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, null, null, $options);
    }
}
