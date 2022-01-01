<?php

require __DIR__ . '/vendor/autoload.php';

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

$app = new \Phpframework\Core\Application();
$app->setRequestData($data);

echo $app->getResponse();
