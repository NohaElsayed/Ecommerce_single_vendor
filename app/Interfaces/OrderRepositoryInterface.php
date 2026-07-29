<?php
// app/Repositories/Interfaces/OrderRepositoryInterface.php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function paginate(int $perPage = 15);
    public function getByCustomer(int $customerId);
    public function getByStatus(string $status);
    public function getRecent(int $limit = 10);
    public function getSalesReport(string $startDate, string $endDate);
}
