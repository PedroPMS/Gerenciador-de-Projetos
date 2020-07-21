<?php

require __DIR__.'/vendor/autoload.php';

use App\Connections\Database;
use App\Models\Tasks;

Database::Conection();

$model = new Tasks;
$model->deleteById(6);
$model->create(['id_user' => 1,'title' => 'Task Massa', 'description' => 'Descrição massa', 'start_date' => '2020-10-01','end_date' => '2020-12-01']);
$model->getAll();