<?php

require __DIR__.'/vendor/autoload.php';

use App\Connections\Database;

var_dump(Database::dropSchema());