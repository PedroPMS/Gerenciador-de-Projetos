<?php

namespace App\Connections;

use App\Tables\Users;
use App\Tables\Task;

class Database
{
    public static $host = "localhost";
    public static $dbname = "teste";
    public static $port = "3308";
    public static $user = "root";
    public static $password = "secret123";

    public static function Conection ()
    {

        try {
            $connection =  new \PDO("mysql:host=".self::$host.";dbname=".self::$dbname.";port=".self::$port, self::$user, self::$password);
            return $connection;
        } catch (\PDOException $error) {
            self::verifyDatabaseExists($error);
        }

    }

    private static function verifyDatabaseExists(\PDOException $error)
    {
        if($error->getCode() == 1049){
            if(self::createSchema())
            {
                $users = new Users;
                $tasks = new Task;

                $users->createTable();
                $tasks->createTable();
            }
        }else{
            echo $error->getMessage();
            die();
        }
    }

    public static function createSchema()
    {
        $dbname = "`".self::$dbname."`";
        $connection =  new \PDO("mysql:host=".self::$host.";port=".self::$port, self::$user, self::$password);
        
        try {
            return $connection->exec("CREATE DATABASE " . $dbname . ";");
        } catch (\PDOException $error) {
            echo 'Erro ao criar o banco de dados' . $error->getMessage();
        }
    }

    public static function dropSchema()
    {
        $connection = self::Conection();
        return $connection->exec("DROP DATABASE " . self::$dbname . ";");
    }
}