<?php

require __DIR__.'/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

$router->group(null)->namespace("App\Controllers");
$router->get("/", "WebController:home");

$router->dispatch();
