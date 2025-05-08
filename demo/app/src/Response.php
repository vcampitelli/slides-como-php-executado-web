<?php

declare(strict_types=1);

readonly class Response
{
    public function __construct(
        public int $status = 200,
        public ?string $body = null,
        public array $headers = [],
    ) {
    }
}
