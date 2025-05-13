<?php

declare(strict_types=1);

namespace App;

use App\Response\JsonResponse;
use App\Response\Response;

class Application
{
    public function __construct(private readonly Router $router)
    {
    }

    public function handle(string $method, string $uri): Response
    {
        try {
            return $this->router->match($method, $uri);
        } catch (\Throwable $t) {
            return new JsonResponse(
                status: 500,
                body: [
                    'error' => $t->getMessage(),
                    'file' => $t->getFile(),
                    'line' => $t->getLine(),
                    'trace' => $t->getTrace(),
                ],
            );
        }
    }

    public function terminate(): void
    {
        error_log('[FrankenPHP] Finalizando request - simulando alguma limpeza...');
    }

    public function shutdown(): void
    {
        error_log('[FrankenPHP] Finalizando app - simulando alguma limpeza...');
    }
}
