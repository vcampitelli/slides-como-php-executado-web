<?php

declare(strict_types=1);

namespace App\Response;

readonly class Response
{
    public array $headers;

    public function __construct(
        public int $status = 200,
        public ?string $body = null,
        array $headers = [],
    ) {
        $headers['X-Process-Pid'] = \getmypid();
        $this->headers = $headers;
    }
}
