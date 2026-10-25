<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Terravision\QRCode\HttpKernel;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = is_string($path) ? $path : '/';

$kernel = new HttpKernel();
$kernel->handle(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $path,
    $_SERVER['QUERY_STRING'] ?? '',
    $_SERVER['HTTP_ACCEPT'] ?? null,
);
