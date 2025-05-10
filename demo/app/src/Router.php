<?php

declare(strict_types=1);

namespace App;

class Router
{
    private const string METHOD_GET = 'get';
    private const string METHOD_POST = 'post';

    /**
     * @var array<string, array<string, callable>>
     */
    private array $routes = [];

    public function get(string $endpoint, callable $callback): self
    {
        return $this->add($endpoint, self::METHOD_GET, $callback);
    }

    public function post(string $endpoint, callable $callback): self
    {
        return $this->add($endpoint, self::METHOD_POST, $callback);
    }

    private function add(string $endpoint, string $method, callable $callback): self
    {
        $this->routes[$endpoint][$method] = $callback;
        return $this;
    }

    public function getRoute(string $url, string $method): ?callable
    {
        return $this->routes[$url][$method] ?? null;
    }
}
