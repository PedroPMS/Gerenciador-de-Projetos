<?php

namespace App\Models;

use App\Connections\Database;
use App\Interfaces\Model;
use PDO;

class Tasks implements Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::Conection();
    }

    public function getAll(): array
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM tasks");
            $query->execute();
            print_r($query->fetchAll(PDO::FETCH_ASSOC));
            return ($query->fetchAll(PDO::FETCH_ASSOC));
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function getById($id): array
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM tasks WHERE id_task = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();
            print_r($query->fetchAll(PDO::FETCH_ASSOC));
            return ($query->fetchAll(PDO::FETCH_ASSOC));
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function editById($id, $data)
    {
        try {
            $query = $this->conn->prepare(
                "UPDATE tasks 
                 SET title = :title,
                     description = :description,
                     start_date = :start_date,
                     end_date = :end_date,
                     completed = :completed
                 WHERE id_task = :id"
            );
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $query->bindValue(':description', $data['description'], PDO::PARAM_STR);
            $query->bindValue(':start_date', $data['start_date'], PDO::PARAM_STR);
            $query->bindValue(':end_date', $data['end_date'], PDO::PARAM_STR);
            $query->bindValue(':completed', $data['completed'], PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function deleteById($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM tasks WHERE id_task = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function create($data)
    {
        print_r($data);
        try {
            $query = $this->conn->prepare(
                "INSERT INTO tasks (id_user,title,description,start_date,end_date,completed)
                 VALUES (:id_user, :title, :description, :start_date, :end_date, 0)"
            );
            $query->bindValue(':id_user', $data['id_user'], PDO::PARAM_STR);
            $query->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $query->bindValue(':description', $data['description'], PDO::PARAM_STR);
            $query->bindValue(':start_date', $data['start_date'], PDO::PARAM_STR);
            $query->bindValue(':end_date', $data['end_date'], PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }
}
