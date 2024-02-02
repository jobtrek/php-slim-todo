<?php

namespace Jobtrek\PhpSlimTodo;

use PDO;

class TodoService
{
    public static function getAllTotdos(PDO $db): array
    {
        $db->query('SELECT * FROM todos');
    }

}
