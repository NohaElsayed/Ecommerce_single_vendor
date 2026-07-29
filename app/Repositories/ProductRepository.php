<?php
// app/Repositories/ProductRepository.php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['category', 'subCategory'])->get();
    }

    public function find(int $id)
    {
        return $this->model->with(['category', 'subCategory'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->with(['category', 'subCategory'])->paginate($perPage);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with(['category', 'subCategory'])->firstOrFail();
    }

    public function getFeatured()
    {
        return $this->model->where('is_featured', true)->where('is_active', true)->take(8)->get();
    }

    public function getByCategory(int $categoryId)
    {
        return $this->model->where('category_id', $categoryId)->where('is_active', true)->paginate(12);
    }

    public function search(string $query)
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('is_active', true)
            ->paginate(12);
    }
}
