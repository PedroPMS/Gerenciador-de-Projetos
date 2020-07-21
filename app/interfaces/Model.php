<?php

namespace App\Interfaces;

interface Model {

    public function getAll(): Array;

    public function getByID(int $id): Array;

    public function editByID(int $id, $data);

    public function deleteByID(int $id);

    public function create(Array $data);
}