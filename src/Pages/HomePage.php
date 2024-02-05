<?php

namespace Jobtrek\PhpSlimTodo\Pages;

use Carbon\Carbon;
use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\Session;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomePage
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $todos = TodoService::getUnFinishedTodos(Database::getInstance()->getDb());
        $todos = array_map(static function ($todo) {
            $todo['due_at'] = (new Carbon($todo['due_at']))->diffForHumans();
            return $todo;
        }, $todos);
        return Twig::fromRequest($request)->render(
            $response,
            'home.twig',
            [
                'todos' => $todos,
                'title' => 'Todo List',
                'message' => Session::getInstance()->getAndForgetSessionKey('message')
            ]
        );
    }
}
