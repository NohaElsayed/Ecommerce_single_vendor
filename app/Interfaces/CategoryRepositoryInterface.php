<?php
// app/Repositories/Interfaces/CategoryRepositoryInterface.php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getActive();
    public function findBySlug(string $slug);
    public function getWithSubCategories();
}
