<?php

namespace App\Connections;

class Database
{
    public static $host = "localhost";
    public static $dbname = "crud_php";
    public static $port = "3308";
    public static $user = "root";
    public static $password = "secret123";

    public static function Conection ()
    {

        try {
            $connection =  new \PDO("mysql:host=".self::$host.";dbname=".self::$dbname.";port=".self::$port, self::$user, self::$password);
        } catch (\PDOException $error) {
            self::verifyDatabaseExists($error);
        }

        return $connection;

    }

    private static function verifyDatabaseExists(\PDOException $error): void
    {
        if($error->getCode() == 1049){
            self::CreateSchema();
        }else{
            echo $error->getMessage();
        }
    }

    public static function CreateSchema()
    {
        $dbname = "`".self::$dbname."`";
        $connection =  new \PDO("mysql:host=".self::$host.";port=".self::$port, self::$user, self::$password);
        
        try {
            return $connection->exec("CREATE DATABASE " . $dbname . ";");
        } catch (\PDOException $error) {
            echo 'Erro ao criar o banco de dados' . $error->getMessage();
        }
    }
}