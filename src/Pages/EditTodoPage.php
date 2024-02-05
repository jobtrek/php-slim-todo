<?php

namespace Jobtrek\PhpSlimTodo\Pages;

use Jobtrek\PhpSlimTodo\Database;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EditTodoPage
{
    /**
     * @param array{'id': int} $args
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $todo = TodoService::getTodoById(Database::getInstance()->getDb(), $args['id']);
        if (!$todo) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }
        return Twig::fromRequest($request)->render(
            $response,
            'edit.twig',
            ['todo' => $todo]
        );
    }

}
