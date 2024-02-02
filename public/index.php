<?php

use Jobtrek\PhpSlimTodo\TodoService;
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
    $todos = TodoService::getUnFinishedTodos($db);
    $todos = array_map(function ($todo) {
        $todo['due_at'] = (new Carbon\Carbon($todo['due_at']))->diffForHumans();
        return $todo;
    }, $todos);
    return Twig::fromRequest($request)->render(
        $response,
        'home.twig',
        ['todos' => $todos, 'title' => 'Todo List']
    );
})->setName('home');

// See done todos
$app->get('/done', function (Request $request, Response $response, $args) use ($db) {
    $todos = TodoService::getFinishedTodos($db);
    return Twig::fromRequest($request)->render(
        $response,
        'home.twig',
        ['todos' => $todos, 'title' => 'Done todos']
    );
})->setName('done');

// Add new todo
$app->post('/todo/create', function (Request $request, Response $response, $args) use ($db) {
    $data = $request->getParsedBody();
    TodoService::createNewTodo($db, $data['title'], $data['description'], $data['due_at']);
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('new-todo');

// Update todo
$app->post('/todo/{id}', function (Request $request, Response $response, $args) use ($db) {
    $data = $request->getParsedBody();
    TodoService::updateTodo(
        $db,
        $args['id'],
        $data['title'],
        $data['description'],
        $data['due_at']
    );
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('update-todo');

// Edit todo
$app->get('/todo/{id}', function (Request $request, Response $response, $args) use ($db) {
    $todo = TodoService::getTodoById($db, $args['id']);
    if (!$todo) {
        return $response->withHeader('Location', '/')->withStatus(302);
    }
    return Twig::fromRequest($request)->render(
        $response,
        'edit.twig',
        ['todo' => $todo]
    );
})->setName('edit-todo');

// Delete todo
$app->get('/todo/delete/{id}', function (Request $request, Response $response, $args) use ($db) {
    TodoService::deleteTodoById($db, $args['id']);
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('edit-todo');

// Tick todo
$app->get('/todo/finished/{id}', function (Request $request, Response $response, $args) use ($db) {
    TodoService::setTodoToFinished($db, $args['id']);
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('edit-todo');

// Untick todo
$app->get('/todo/un-finish/{id}', function (Request $request, Response $response, $args) use ($db) {
    TodoService::setTodoToUnFinished($db, $args['id']);
    return $response->withHeader('Location', '/')->withStatus(302);
})->setName('edit-todo');

// Run app
$app->run();
