<?php
// app/Repositories/RoleRepository.php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use App\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $model)
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
        $role = $this->find($id);
        $role->update($data);
        return $role;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }
}
