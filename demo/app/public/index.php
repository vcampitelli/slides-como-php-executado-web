<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Response.php';
require_once __DIR__ . '/../src/JsonResponse.php';

$url = '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$response = match ($url) {
    '/' => new Response(body: 'Hello, world'),
    '/json' => new JsonResponse(body: ['status' => true]),
    default => new Response(status: 404),
};

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
