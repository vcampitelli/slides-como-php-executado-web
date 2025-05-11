<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$url = '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

try {
    $response = match ($url) {
        '/' => new App\Response\Response(body: 'Hello, World!'),
        '/singleton' => new App\Response\JsonResponse(body: ['singleton' => App\Singleton::getInstance()->date]),
        default => new App\Response\Response(status: 404),
    };
} catch (\Throwable $t) {
    $response = new App\Response\JsonResponse(
        status: 500,
        body: [
            'error' => $t->getMessage(),
            'file' => $t->getFile(),
            'line' => $t->getLine(),
            'trace' => $t->getTrace(),
        ],
    );
}

if (!empty($_SERVER['SWOOLE'])) {
    return $response;
}

http_response_code($response->status);
foreach ($response->headers as $name => $value) {
    header("{$name}: {$value}", false);
}
if (php_sapi_name() === 'fpm-fcgi') {
    header('X-Process-Pid: ' . getmypid());
}
echo $response->body;
