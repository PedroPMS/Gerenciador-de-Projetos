<?php

namespace App\Interfaces;

interface Tables {

    public function createTable(): ?\PDO;
}