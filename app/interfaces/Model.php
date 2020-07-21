<?php

namespace App\Interfaces;

interface Model
{

    public function getAll(): array;

    public function getByID(int $id): array;

    public function editByID(int $id, $data);

    public function deleteByID(int $id);

    public function create(array $data);
}
