<?php

namespace App\Connections;

use App\Tables\Users;
use App\Tables\Tasks;

class Database
{
    public static $host = "localhost";
    public static $dbname = "teste1";
    public static $port = "3306";
    public static $user = "root";
    public static $password = "";

    public static function Conection()
    {
        try {
            $connection =  new \PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";port=" . self::$port, self::$user, self::$password);
            return $connection;
        } catch (\PDOException $error) {
            self::verifyDatabaseExists($error);
        }
    }

    private static function verifyDatabaseExists(\PDOException $error)
    {
        if ($error->getCode() == 1049) {
            if (self::createSchema()) {
                self::createTables();
            }
        } else {
            echo $error->getMessage();
            die();
        }
    }

    public static function createSchema()
    {
        $dbname = "`" . self::$dbname . "`";
        $connection =  new \PDO("mysql:host=" . self::$host . ";port=" . self::$port, self::$user, self::$password);

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

    public static function getTablesClasses(): array
    {
        $directory = __DIR__ . "/../tables";
        $directory = scandir($directory);
        $files     = array_diff($directory, array('.', '..'));

        if (!$files) {
            echo 'Erro ao carregar diretório de tabelas ';
        }

        return str_replace(".php", "", $files);
    }

    public static function createTables(): void
    {
        $tables           = self::getTablesClasses();
        $tablesNamespace  = "App\Tables\\";

        foreach ($tables as $table) {
            $tableWithNamespace = $tablesNamespace . $table;
            $table = new $tableWithNamespace();
            $table->createTable();
        }
    }
}
