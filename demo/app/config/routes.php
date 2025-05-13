<?php

declare(strict_types=1);

use App\Response\JsonResponse;
use App\Response\Response;
use App\Router;

return function (Router $router) {
    $router
        ->get('/', fn() => new Response(body: 'Hello, World!'))
        ->get(
            '/singleton',
            fn() => new JsonResponse(body: ['singleton' => App\Singleton::getInstance()->date])
        );
};
