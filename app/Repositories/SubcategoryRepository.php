<?php
// app/Repositories/SubcategoryRepository.php

namespace App\Repositories;

use App\Models\SubCategory;
use App\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryRepository implements SubcategoryRepositoryInterface
{
    protected $model;

    public function __construct(SubCategory $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('category')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $subcategory = $this->find($id);
        $subcategory->update($data);
        return $subcategory;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function getByCategory(int $categoryId)
    {
        return $this->model->where('category_id', $categoryId)->where('is_active', true)->get();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->with('category')->paginate($perPage);
    }
}
