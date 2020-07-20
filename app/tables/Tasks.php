<?php

namespace App\Tables;

use App\Connections\Database;
use App\Interfaces\Table;
class Tasks implements Table
{
    public $conn;
    public $tableName = 'tasks';

    public function __construct()
    {
       $this->conn = Database::Conection();
    }

    public function createTable(): int
    {
        $verify = $this->conn->exec(
            "CREATE TABLE `$this->tableName`(
                id_task INT NOT NULL AUTO_INCREMENT,
                id_user INT NOT NULL,
                title VARCHAR(50),
                description VARCHAR(50),
                start_date DATE,
                end_date DATE,
                completed BOOLEAN,
                PRIMARY KEY ( id_task ),
                FOREIGN KEY (id_user) REFERENCES users (id)
                
            )"
        );

        if($verify === false)
            echo 'Erro ao criar tabela Tasks ';
        else
            return $verify;
        
    }
}