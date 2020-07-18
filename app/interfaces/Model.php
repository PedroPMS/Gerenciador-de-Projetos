<?php

namespace App\Interfaces;

interface Model {

    public static function getAll(): Array;

    public static function getByID(int $id): Array;

    public static function editByID(int $id);

    public static function deleteByID(int $id);

    public static function create(Array $data);
}