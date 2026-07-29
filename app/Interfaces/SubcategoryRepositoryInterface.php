<?php
// app/Repositories/Interfaces/SubcategoryRepositoryInterface.php

namespace App\Interfaces;

interface SubcategoryRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByCategory(int $categoryId);
    public function paginate(int $perPage = 15);
}
