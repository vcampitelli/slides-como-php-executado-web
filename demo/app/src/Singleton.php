<?php

declare(strict_types=1);

namespace App;

class Singleton
{
    private static Singleton $instance;

    private function __construct(
        public private(set) readonly \DateTimeImmutable $date
    ) {
    }

    public static function getInstance(): Singleton
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(new \DateTimeImmutable('now'));
        }
        return self::$instance;
    }
}
