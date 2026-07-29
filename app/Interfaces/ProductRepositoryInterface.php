<?php
// app/Repositories/Interfaces/ProductRepositoryInterface.php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function paginate(int $perPage = 15);
    public function findBySlug(string $slug);
    public function getFeatured();
    public function getByCategory(int $categoryId);
    public function search(string $query);
}
