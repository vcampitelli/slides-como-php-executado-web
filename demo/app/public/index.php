<?php

declare(strict_types=1);

$application = require __DIR__ . '/../bootstrap/app.php';
$response = $application->handle(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/'
);

if (!empty($_ENV['__RETURN__RESPONSE__'])) {
    return $response;
}

$dispatcher = new App\Response\Dispatcher();
$dispatcher($response);
