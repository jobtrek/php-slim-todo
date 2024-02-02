<?php

namespace Jobtrek\PhpSlimTodo;

use PDO;

class TodoService
{
    public static function getAllTodos(PDO $db): array
    {
        return $db->query('select * from todo')->fetchAll();
    }

    public static function getUnFinishedTodos(PDO $db): array
    {
        return $db->query('select * from todo where finished = 0')->fetchAll();
    }

    public static function getFinishedTodos(PDO $db): array
    {
        return $db->query('select * from todo where finished = 1')->fetchAll();
    }

    public static function createNewTodo(PDO $db, string $title, string $description, string $due_at): void
    {
        $db->prepare('insert into todo (title, description, due_at) values (?, ?, ?)')->execute(
            [$title, $description, $due_at]
        );
    }

    public static function updateTodo(PDO $db, int $id, string $title, string $description, string $due_at): void
    {
        $db->prepare('update todo set title = ?, description = ?, due_at = ? where id = ?')
            ->execute([$title, $description, $due_at, $id]);
    }

    public static function getTodoById(PDO $db, mixed $id): array
    {
        $stmt = $db->prepare('select * from todo where id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function deleteTodoById(PDO $db, mixed $id): void
    {
        $stmt = $db->prepare('delete from todo where id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function setTodoToFinished(PDO $db, mixed $id): void
    {
        $db->prepare('update todo set finished = true where id = ?')
            ->execute([$id]);
    }

    public static function setTodoToUnFinished(PDO $db, mixed $id): void
    {
        $db->prepare('update todo set finished = false where id = ?')
            ->execute([$id]);
    }
}
