<?php

declare(strict_types=1);

namespace App\Response;

class Dispatcher
{
    public function __invoke(Response $response): void
    {
        \http_response_code($response->status);

        foreach ($response->headers as $name => $value) {
            \header("{$name}: {$value}", false);
        }

        echo $response->body;
    }
}
