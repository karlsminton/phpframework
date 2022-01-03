<?php

use Phpframework\Core\Application;

require __DIR__ . '/vendor/autoload.php';

/** @var \DI\Container $di */
$di = require __DIR__ . '/bootstrap.php';

const PATHS = [
    'modules' => __DIR__ . '/modules/Phpframework',
    'templates' => __DIR__ . '/templates'
];

$data = array_merge(
    $_SERVER ?? [],
    $_SESSION ?? [],
    $_GET ?? [],
    $_POST ?? []
);

$app = $di->get(Application::class);
$app->setRequestData($data)
    ->setDiContainer($di)
    ->buildRouterPool();

echo $app->getResponse();
