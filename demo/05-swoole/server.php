#!/usr/bin/env php
<?php
/**
 * @link https://github.com/swoole/docker-swoole/blob/master/examples/02-www/rootfilesystem/var/www/server.php
 */

declare(strict_types=1);

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$_ENV['__RETURN__RESPONSE__'] = true;
$http = new Server('0.0.0.0', $_ENV['PORT'] ?? 80, SWOOLE_PROCESS);
$http->on(
    'start',
    function (Server $http) {
        echo "Swoole HTTP server listening at :{$http->port}.\n";
    }
);

function run() {
    return require '/var/www/html/public/index.php';
}

$http->on(
    'request',
    function (Request $request, Response $response) {
        $_SERVER['REQUEST_URI'] = $request->server['request_uri'];
        $_SERVER['REQUEST_METHOD'] = $request->server['request_method'];
        $applicationResponse = run();

        $response->setStatusCode($applicationResponse->status);
        foreach ($applicationResponse->headers as $name => $value) {
            $response->setHeader($name, $value);
        }
        $response->end($applicationResponse->body);
    }
);
$http->start();
