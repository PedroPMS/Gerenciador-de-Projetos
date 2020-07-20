<?php

require __DIR__.'/vendor/autoload.php';

use App\Factories\UserFactory;
use App\Factories\TaskFactory;

$createUsers = new UserFactory;
$createTasks = new TaskFactory;

$createUsers->generateUsers(5);
$createTasks->generateTasks(5);