<?php

declare(strict_types=1);

namespace App\Response;
readonly class JsonResponse extends \Response
{
    public function __construct(
        int $status = 200,
        array|\JsonSerializable|null $body = null,
        array $headers = [],
    ) {
        $body = \json_encode($body, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $headers['Content-Type'] = 'application/json';
        parent::__construct($status, $body, $headers);
    }
}
