<?php

namespace App\Factories;

use App\Connections\Database;
use App\Factories\GenerateData;
use PDO;

class TaskFactory
{
    public $conn;

    public function __construct()
    {
        $this->conn = Database::Conection();
    }

    public function generateTasks($rows)
    {
        $i = 0;
        $dateInterval = ["01 January 2019", "01 December 2020"];
        while ($i < $rows) {
            // $id_taks -> NOT NULL AUTO_INCREMENTE PRIMARY KEY
            $id_user = $this->aleatoryUser(); // -> NOT NULL FOREIGN KEY
            $title = GenerateData::generateString(10); // -> VARCHAR(50)
            $description = GenerateData::generateString(30); // -> VARCHAR(50)
            $dates =  $this->startAndEndDate(GenerateData::generateDate($dateInterval), GenerateData::generateDate($dateInterval));
            $start_date = $dates[0]; // -> DATE
            $end_date = $dates[1]; // -> DATE
            $completed = GenerateData::generateBoolean(); // -> TINYINT(1)
            $values =  "$id_user,'$title','$description','$start_date','$end_date',$completed";
            $this->insertData($values);
            $i++;
        }
    }

    private function insertData($values)
    {
        try {
            $query = "INSERT INTO tasks (id_user,title,description,start_date,end_date,completed) VALUES ($values)";
            $this->conn->exec($query);
            echo 'Registro criado' . PHP_EOL;
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    private function startAndEndDate($date1, $date2)
    {
        if (strtotime($date1) > strtotime($date2)) {
            return [$date2,$date1];
        }else{
            return [$date1,$date2];
        }
    }

    private function aleatoryUser()
    {
        $users = $this->getUsersId();
        $index = array_rand($users);
        return ($users[$index]);
    }

    private function getUsersId(): array
    {
        $query = $this->conn->prepare("SELECT id FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}
