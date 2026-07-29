<?php
// app/Repositories/PermissionRepository.php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use App\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $permission = $this->find($id);
        $permission->update($data);
        return $permission;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }
}
