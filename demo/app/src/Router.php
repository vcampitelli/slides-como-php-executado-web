<?php

declare(strict_types=1);

namespace App;

use App\Response\Response;

class Router
{
    /**
     * @var array<string, array<string, callable():Response>>
     */
    private array $endpoints = [];

    public function get(string $uri, callable $callback): self
    {
        return $this->add('GET', $uri, $callback);
    }

    private function add(string $method, string $uri, callable $callback): self
    {
        if (!isset($this->endpoints[$uri])) {
            $this->endpoints[$uri] = [];
        }
        $this->endpoints[$uri][$method] = $callback;
        return $this;
    }

    public function match(string $method, string $uri): Response
    {
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');;
        if (!isset($this->endpoints[$uri])) {
            return new Response(status: 404);
        }

        $method = \strtoupper($method);
        if (!isset($this->endpoints[$uri][$method])) {
            return new Response(
                status: 405,
                body: 'Allowed methods: ' . \implode(', ', \array_keys($this->endpoints[$uri]))
            );
        }

        $response = $this->endpoints[$uri][$method]();
        if (!($response instanceof Response)) {
            return new Response(
                status: 500,
                body: 'Invalid response type. Expected instance of ' . Response::class,
            );
        }

        return $response;
    }
}
