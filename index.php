<?php

require __DIR__.'/vendor/autoload.php';
require realpath("app/Config.php");

use CoffeeCode\Router\Router;

$router = new Router('http://localhost/html/Gerenciador-de-Projetos/');
$router->namespace("App\Controllers");

$router->group(null);
$router->get("/", "WebController:home");
$router->get("/cadastro", "WebController:register");
$router->post("/cadastro", "UserController:createUser");
$router->post("/auth", "AuthController:login");
$router->get("/logout", "AuthController:logout");
$router->get("/user/{id}", "UserController:userProfile");
$router->get("/addTask/{id}", "TaskController:formCreateTasks");
$router->post("/addTask/{id}", "TaskController:createTasks");
$router->get("/tasks/{id}", "TaskController:showAllUsersTasks");
$router->get("/gerenciar", "UserController:management");

$router->dispatch();

$router->group("error")->namespace("Test");
$router->get("/{errcode}", "WebController:notFound");
