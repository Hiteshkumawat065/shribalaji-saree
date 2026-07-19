<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->all($filters);
    }

    public function find($id): Product
    {
        return $this->repository->find($id);
    }

    public function findBySlug(string $slug): Product
    {
        return $this->repository->findBySlug($slug);
    }

    public function create(array $data): Product
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data): Product
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->search($query, $filters);
    }

    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return $this->repository->getFeaturedProducts($limit);
    }

    public function getCategories(): Collection
    {
        return $this->repository->getCategories();
    }

    public function getTotalProducts(): int
    {
        return Product::count();
    }

    public function incrementViews($id): void
    {
        Product::where('id', $id)->increment('views');
    }
}