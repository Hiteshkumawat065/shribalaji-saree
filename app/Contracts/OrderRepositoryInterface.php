<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;

    public function find($id): Order;

    public function findByOrderNumber(string $orderNumber): Order;

    public function create(array $data): Order;

    public function update($id, array $data): Order;

    public function delete($id): bool;

    public function getUserOrders($userId): LengthAwarePaginator;

    public function getPendingOrders(): Collection;

    public function getTotalRevenue(): float;

    public function getRecentOrders(int $limit = 10): Collection;
}

