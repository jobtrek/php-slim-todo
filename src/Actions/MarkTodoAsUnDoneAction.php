<?php

namespace Jobtrek\PhpSlimTodo\Actions;

use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MarkTodoAsUnDoneAction
{
    /**
     * @param array{'id': int} $args
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        TodoService::setTodoToUnFinished(Database::getInstance()->getDb(), $args['id']);
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
