<?php

$app = require __DIR__ . '/../bootstrap.php';

$app['debug']=true;

if (isset($env) && $env == 'test') {
    return $app;
}

$app->run();
