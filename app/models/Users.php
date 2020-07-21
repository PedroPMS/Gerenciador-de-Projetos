<?php

namespace App\Models;

use App\Connections\Database;
use App\Interfaces\Model;
use PDO;

class Users implements Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::Conection();
    }
 
    public function getAll(): Array
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users");
            $query->execute();
            return ($query->fetchAll(PDO::FETCH_ASSOC));
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function getById($id): Array
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $query->bindValue(':id',$id, PDO::PARAM_STR);
            $query->execute();
            return ($query->fetchAll(PDO::FETCH_ASSOC));
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function editById($id, $data)
    {
        try {
            $query = $this->conn->prepare("UPDATE users SET admin = :admin, email = :email WHERE id = :id");
            $query->bindValue(':id',$id, PDO::PARAM_STR);
            $query->bindValue(':email',$data['email'], PDO::PARAM_STR);
            $query->bindValue(':admin',$data['admin'], PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function deleteById($id)
    {
        try {
            $query = $this->conn->prepare("DELETE FROM users WHERE id = :id");
            $query->bindValue(':id',$id, PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

    public function create($data)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO users (admin,email,password) VALUE(:email, :admin, :password)");
            $query->bindValue(':email',$data['email'], PDO::PARAM_STR);
            $query->bindValue(':admin',$data['admin'], PDO::PARAM_STR);
            $query->bindValue(':password',password_hash($data['password'],PASSWORD_DEFAULT), PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }

}