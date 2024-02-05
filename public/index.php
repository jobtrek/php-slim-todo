<?php

use Jobtrek\PhpSlimTodo\Actions\CreateTodoAction;
use Jobtrek\PhpSlimTodo\Actions\DeleteTodoAction;
use Jobtrek\PhpSlimTodo\Actions\MarkTodoAsDoneAction;
use Jobtrek\PhpSlimTodo\Actions\MarkTodoAsUnDoneAction;
use Jobtrek\PhpSlimTodo\Actions\UpdateTodoAction;
use Jobtrek\PhpSlimTodo\Pages\DoneTodosPage;
use Jobtrek\PhpSlimTodo\Pages\EditTodoPage;
use Jobtrek\PhpSlimTodo\Pages\HomePage;
use Jobtrek\PhpSlimTodo\SessionMiddleware;
use Jobtrek\PhpSlimTodo\TodoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false/*__DIR__ . '/../cache'*/]);

// Register a session middleware
$app->add(new SessionMiddleware());
$app->addRoutingMiddleware();

$app->add(TwigMiddleware::create($app, $twig));

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Show all todos
$app->get('/', HomePage::class)->setName('home');

// See done todos
$app->get('/done', DoneTodosPage::class)->setName('done');

// Add new todo
$app->post('/todo/create', CreateTodoAction::class)->setName('new-todo');

// Update todo
$app->post('/todo/{id}', UpdateTodoAction::class)->setName('update-todo');

// Edit todo
$app->get('/todo/{id}', EditTodoPage::class)->setName('edit-todo');

// Delete todo
$app->get('/todo/delete/{id}', DeleteTodoAction::class)->setName('edit-todo');

// Tick todo
$app->get('/todo/finished/{id}', MarkTodoAsDoneAction::class)->setName('edit-todo');

// Untick todo
$app->get('/todo/un-finish/{id}', MarkTodoAsUnDoneAction::class)->setName('edit-todo');

// Run app
$app->run();
