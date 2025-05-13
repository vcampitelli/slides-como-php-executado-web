<?php
/**
 * @link https://frankenphp.dev/docs/worker/
 */

declare(strict_types=1);

ignore_user_abort(true);

/** @var App\Application $application */
$application = require __DIR__ . '/../bootstrap/app.php';
$dispatcher = new App\Response\Dispatcher();

$handler = static function () use ($application, $dispatcher) {
    error_log("[FrankenPHP] Requisição recebida");
    $response = $application->handle(
        $_SERVER['REQUEST_METHOD'] ?? 'GET',
        $_SERVER['REQUEST_URI'] ?? '/'
    );
    $dispatcher($response);
};

error_log("[FrankenPHP] Iniciando worker");
$maxRequests = (int) ($_SERVER['MAX_REQUESTS'] ?? 0);
for ($nbRequests = 0; !$maxRequests || $nbRequests < $maxRequests; ++$nbRequests) {
    error_log("[FrankenPHP] Aguardando requisição...");
    $keepRunning = \frankenphp_handle_request($handler);

    $application->terminate();

    // Call the garbage collector to reduce the chances of it being triggered in the middle of a page generation
    \gc_collect_cycles();

    if (!$keepRunning) {
        break;
    }
}

$application->shutdown();
