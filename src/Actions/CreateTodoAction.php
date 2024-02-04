<?php

namespace Jobtrek\PhpSlimTodo\Actions;

use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\Session;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateTodoAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = $request->getParsedBody();
        TodoService::createNewTodo(
            Database::getInstance()->getDb(),
            $data['title'],
            $data['description'],
            $data['due_at']
        );
        Session::getInstance()->setSessionKey('message', 'Todo created successfully');
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
