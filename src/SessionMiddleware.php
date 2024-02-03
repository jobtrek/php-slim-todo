<?php

namespace Jobtrek\PhpSlimTodo;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware
{
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $session = Session::getInstance();
        $session->start();
        $response = $handler->handle($request);
        $session->save();
        return $response;
    }
}
