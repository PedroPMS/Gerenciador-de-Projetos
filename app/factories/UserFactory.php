<?php

namespace App\Factories;

use App\Connections\Database;
use App\Factories\GenerateData;

class UserFactory
{
    public $conn;

    public function __construct()
    {
        $this->conn = Database::Conection();
    }

    public function generateUsers($rows)
    {
        $i = 0;
        while ($i < $rows) {
            // $id -> NOT NULL AUTO_INCREMENTE PRIMARY KEY
            $admin = GenerateData::generateBoolean(); // -> TINYINT(1)
            $email = GenerateData::generateString(10).'@gmail.com'; // -> VARCHAR(50)
            $password = GenerateData::generateString(10); // -> VARCHAR(50)
            $values =  "$admin,'$email', '$password'";
            $this->insertData($values);
            $i++;
        }
    }

    private function insertData($values)
    {
        try {
            $query = "INSERT INTO users (admin,email,password) VALUES ($values)";
            $this->conn->exec($query);
            echo 'Registro criado' . PHP_EOL;
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }
}