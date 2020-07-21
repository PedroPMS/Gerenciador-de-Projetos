<?php

require __DIR__.'/vendor/autoload.php';

use App\Connections\Database;
use App\Models\Users;

Database::Conection();

$model = new Users;
$model->editById(3,['email' => 'jao@gmail.com', 'admin' => 1]);