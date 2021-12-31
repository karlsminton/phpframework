<?php

require __DIR__ . '/vendor/autoload.php';

define(
    'PATHS',
    [
        'modules' => __DIR__ . '/modules/Phpframework'
    ]
);

$data = array_merge(
    $_SERVER ?? [],
    $_SESSION ?? [],
    $_GET ?? [],
    $_POST ?? []
);

$app = new \Phpframework\Core\Application();
$app->setRequestData($data);

echo $app->getResponse();
