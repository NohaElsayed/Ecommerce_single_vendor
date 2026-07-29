<?php
// app/Repositories/OrderRepository.php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['customer', 'items'])->get();
    }

    public function find(int $id)
    {
        return $this->model->with(['customer', 'items.product'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->with(['customer'])->latest()->paginate($perPage);
    }

    public function getByCustomer(int $customerId)
    {
        return $this->model->where('customer_id', $customerId)->with('items')->latest()->get();
    }

    public function getByStatus(string $status)
    {
        return $this->model->where('status', $status)->paginate(15);
    }

    public function getRecent(int $limit = 10)
    {
        return $this->model->with('customer')->latest()->take($limit)->get();
    }

    public function getSalesReport(string $startDate, string $endDate)
    {
        return $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('date')
            ->get();
    }
}
