<?php
// app/Repositories/CategoryRepository.php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('subCategories')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('subCategories')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)->with('activeSubCategories')->get();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with('activeSubCategories')->firstOrFail();
    }

    public function getWithSubCategories()
    {
        return $this->model->with('subCategories')->get();
    }
}
