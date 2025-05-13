<?php

use Spiral\RoadRunner;
use Nyholm\Psr7;

require __DIR__ . '/vendor/autoload.php';

$worker = RoadRunner\Worker::create();
$psrFactory = new Psr7\Factory\Psr17Factory();

$worker = new RoadRunner\Http\PSR7Worker($worker, $psrFactory, $psrFactory, $psrFactory);

/** @var App\Application $application */
$application = require __DIR__ . '/bootstrap/app.php';

while ($req = $worker->waitRequest()) {
    try {
        $response = $application->handle(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'] ?? '/'
        );

        $psr7Response = new Psr7\Response();
        foreach ($response->headers as $header => $value) {
            $psr7Response = $psr7Response->withHeader($header, $value);
        }
        $psr7Response->getBody()->write($response->body);

        $worker->respond($psr7Response);
    } catch (\Throwable $e) {
        $worker->getWorker()->error((string)$e);
    }
}
