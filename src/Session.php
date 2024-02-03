<?php

namespace Jobtrek\PhpSlimTodo;

class Session
{
    private static null|Session $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function start(): void
    {
        session_start();
    }

    public function save(): void
    {
        session_write_close();
    }

    public function setSessionKey(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getSessionKey(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function clearSessionKeys(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clearAllSessionKeys(): void
    {
        session_destroy();
    }

    /**
     * @throws \RuntimeException when trying to unserialize a singleton
     */
    public function __wakeup()
    {
        throw new \RuntimeException('Singleton can not be unserialized');
    }

    private function __clone()
    {
    }
}
