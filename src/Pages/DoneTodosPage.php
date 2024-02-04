<?php

namespace Jobtrek\PhpSlimTodo\Pages;

use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class DoneTodosPage
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $todos = TodoService::getFinishedTodos(Database::getInstance()->getDb());
        return Twig::fromRequest($request)->render(
            $response,
            'home.twig',
            ['todos' => $todos, 'title' => 'Done todos']
        );
    }
}
