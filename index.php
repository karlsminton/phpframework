<?php

require __DIR__ . '/vendor/autoload.php';

$data = array_merge(
    $_SERVER ?? [],
    $_SESSION ?? [],
    $_GET ?? [],
    $_POST ?? []
);

$app = new \Phpframework\Core\Application();
$app->setRequestData($data);

echo $app->getResponse();
