<?php

namespace Jobtrek\PhpSlimTodo\Actions;

use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateTodoAction
{
    /**
     * @param array{'id': int} $args
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data = $request->getParsedBody();
        TodoService::updateTodo(
            Database::getInstance()->getDb(),
            $args['id'],
            $data['title'],
            $data['description'],
            $data['due_at']
        );
        return $response->withHeader('Location', '/')->withStatus(302);
    }

}
