<?php

require __DIR__.'/vendor/autoload.php';

use App\Factories\Factory;

$populate = new Factory;
$populate->populateDatabase();