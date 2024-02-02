<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false/*__DIR__ . '/../cache'*/]);

$app->addRoutingMiddleware();
$app->add(TwigMiddleware::create($app, $twig));

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$db = \Jobtrek\PhpSlimTodo\Database::getDatabaseConnection(__DIR__ . '/../database.db');

// Show all todos
$app->get('/', function (Request $request, Response $response, $args) use ($db) {
    $todos = \Jobtrek\PhpSlimTodo\TodoService::getUnFinishedTodos($db);
    return Twig::fromRequest($request)->render(
        $response,
        'home.twig',
        ['todos' => $todos, 'title' => 'Todo List']
    );
})->setName('home');

// See done todos
$app->get('/done', function (Request $request, Response $response, $args) use ($db) {
    $todos = \Jobtrek\PhpSlimTodo\TodoService::getFinishedTodos($db);
    return Twig::fromRequest($request)->render(
        $response,
        'home.twig',
        ['todos' => $todos, 'title' => 'Done todos']
    );
})->setName('done');

// Add new todo
$app->post('/new-todo', function (Request $request, Response $response, $args) use ($db) {
    $data = $request->getParsedBody();
    \Jobtrek\PhpSlimTodo\TodoService::createNewTodo($db, $data['title'], $data['description'], $data['due_at']);
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('new-todo');

// Run app
$app->run();
