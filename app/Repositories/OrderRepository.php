<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'items']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function find($id): Order
    {
        return $this->model->with(['user', 'items', 'payment'])->findOrFail($id);
    }

    public function findByOrderNumber(string $orderNumber): Order
    {
        return $this->model->with(['user', 'items', 'payment'])->where('order_number', $orderNumber)->firstOrFail();
    }

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): Order
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function getUserOrders($userId): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getPendingOrders(): Collection
    {
        return $this->model->where('status', 'pending')
            ->where('payment_status', 'pending')
            ->with(['user', 'items'])
            ->get();
    }

    public function getTotalRevenue(): float
    {
        return $this->model->where('payment_status', 'paid')
            ->sum('total');
    }

    public function getRecentOrders(int $limit = 10): Collection
    {
        return $this->model->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}