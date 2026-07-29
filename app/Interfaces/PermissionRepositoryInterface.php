<?php
// app/Repositories/Interfaces/PermissionRepositoryInterface.php

namespace App\Interfaces;

interface PermissionRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function findByName(string $name);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
