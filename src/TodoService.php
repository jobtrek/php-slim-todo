<?php

namespace Jobtrek\PhpSlimTodo;

use PDO;

class TodoService
{
    public static function getAllTodos(PDO $db): array
    {
        return $db->query('SELECT * FROM todo')->fetchAll();
    }

    public static function getUnFinishedTodos(PDO $db): array
    {
        return $db->query('SELECT * FROM todo WHERE finished = 0')->fetchAll();
    }

    public static function getFinishedTodos(PDO $db): array
    {
        return $db->query('SELECT * FROM todo WHERE finished = 1')->fetchAll();
    }

    public static function createNewTodo(PDO $db, string $title, string $description, string $due_at): void
    {
        $db->prepare('INSERT INTO todo (title, description, due_at) VALUES (?, ?, ?)')->execute([$title, $description, $due_at]);
    }
}
