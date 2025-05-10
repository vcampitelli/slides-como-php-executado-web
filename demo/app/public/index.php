<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$container = new App\Container();
$container->register(App\SomeDependency::class, fn() => new App\SomeDependency());

$router = new App\Router();

$url = '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$handler = match ($url) {
    '/' => fn() => new App\Response\Response(body: 'Hello, world'),
    '/json' => fn() => new App\Response\JsonResponse(body: ['status' => true]),
    '/singleton' => fn() => new App\Response\JsonResponse(body: ['singleton' => \App\Singleton::getInstance()->date]),
    default => fn() => new App\Response\Response(status: 404),
};

try {
    $response = $handler();
} catch (\Throwable $t) {
    $response = new App\Response\JsonResponse(
        status: 500,
        body: [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
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
