<?php

require __DIR__.'/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router('URL_BASE');
$router->namespace("App\Controllers");

$router->group(null);
$router->get("/", "WebController:home");
$router->get("/cadastro", "WebController:register");
$router->post("/cadastro", "WebController:createUser");

$router->dispatch();
