<?php

namespace App\Factories;

use App\Connections\Database;
use PDO;

class Factory
{
    public $conn;
    public $rows = 5;

    public function __construct()
    {
        $this->conn = Database::Conection();
    }

    public function populateDatabase(): void
    {
        $i = 0;
        $tables = Database::getTablesClasses();

        foreach ($tables as $table) {
            while ($i < $this->rows) {
                $this->prepareData(strtolower($table));
                $i++;
            }
            $i = 0;
        }
    }

    private function prepareData($table): void
    {
        $insertList = [];
        $insertList['table'] = $table;
        $verify = $this->conn->prepare("DESCRIBE `$table`");
        $verify->execute();
        $table_fields = $verify->fetchAll();

        foreach ($table_fields as $fiels) {
            if ($fiels['Key'] != 'PRI') {
                $insertList[$fiels['Field']] = $this->generate($fiels['Field'], $fiels['Type'], $fiels['Key']);
            }
        }
        if ($table == 'tasks' && strtotime($insertList['start_date']) > strtotime($insertList['end_date'])) {
            $insertList = $this->replaceDate($insertList);
        }

        $this->insertData($insertList);
        $insertList = [];
    }

    private function insertData($insertList): void
    {
        $table = $insertList['table'];
        $fields = '';
        $values = '';
        foreach ($insertList as $key => $data) {

            if ($key != 'table') {
                $fields .=  $key . ',';
                $values .=  $data . ',';
            }
        }
        $values =  substr($values, 0, -1);
        $fields =  substr($fields, 0, -1);

        try {
            $query = "INSERT INTO $table ($fields) VALUES ($values)";
            $this->conn->exec($query);
            echo 'Registro criado' . PHP_EOL;
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function generate($field, $type, $key)
    {
        $email = 'lorem';

        switch ($type) {
            case strpos($type, 'tinyint') === 0:
                return rand(0, 1);
                break;

            case strpos($type, 'varchar') === 0:
                if ($field == 'email') {
                    $email = str_shuffle($email) . '@gmail.com';
                    return $email = "'$email'";
                } else {
                    return $this->getRandomWord(10);
                }
                break;

            case $type === 'int(11)' && $key != 'MUL':
                return rand(1, 255);
                break;

            case $type === 'date':
                return $this->randomDateInRange();
                break;
            case $key == 'MUL':
                return rand(1, $this->rows);
                break;

            default:
                break;
        }
    }

    public function getRandomWord($len): String
    {
        $string     = '';
        $vowels     = array("a", "e", "i", "o", "u");
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        );

        // Seed it
        srand((float) microtime() * 1000000);

        $max = $len / 2;
        for ($i = 1; $i <= $max; $i++) {
            $string .= $consonants[rand(0, 19)];
            $string .= $vowels[rand(0, 4)];
        }

        return $string = "'$string'";
    }

    public function randomDateInRange(): String
    {
        $start = strtotime("10 January 2019");
        $end = strtotime("22 July 2020");
        $timestamp = mt_rand($start, $end);

        $date = date("Y-m-d", $timestamp);
        return $date = "'$date'";
    }

    public function replaceDate($insertList): Array
    {
        $replace = [
            'start_date' => $insertList['end_date'],
            'end_date' => $insertList['start_date']
        ];
        return $insertList = array_replace($insertList, $replace);
    }
}
