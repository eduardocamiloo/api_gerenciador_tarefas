<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set($_ENV['APP_TIMEZONE']);

$app = AppFactory::create();
$app->setBasePath($_ENV['APP_BASE_PATH']);

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode(["message" => "Hello World! Essa é uma api de gerenciamento de tarefas (CRUD)"]));

    return $response->withHeader("Content-Type", "application/json");
});

(require __DIR__ . '/src/Routes/tarefas.php')($app);

$app->run();
