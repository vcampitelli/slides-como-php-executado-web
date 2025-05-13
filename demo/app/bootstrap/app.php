<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

/** @var callable(App\Router):void $routes */
$routes = require __DIR__  . '/../config/routes.php';
$router = new App\Router();
$routes($router);

return new App\Application($router);
