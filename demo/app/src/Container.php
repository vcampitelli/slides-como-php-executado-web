<?php

declare(strict_types=1);

namespace App;

class Container
{
    /**
     * @var array<class-string, callable>
     */
    private array $definitions = [];

    /**
     * @var array<class-string, object>
     */
    private array $instances = [];

    /**
     * @param class-string $class
     * @param callable $definition
     * @return $this
     */
    public function register(string $class, callable $definition): self
    {
        $this->definitions[$class] = $definition;
        return $this;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function has(string $class): bool
    {
        return isset($this->definitions[$class]);
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return object<T>
     */
    public function get(string $class): object
    {
        if (!$this->has($class)) {
            throw new \RuntimeException("Class {$class} not found in Container");
        }

        if (!isset($this->instances[$class])) {
            $this->instances[$class] = $this->definitions[$class]();
        }

        return $this->instances[$class];
    }

}
