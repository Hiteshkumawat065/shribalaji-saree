<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;

    public function find($id): Product;

    public function findBySlug(string $slug): Product;

    public function create(array $data): Product;

    public function update($id, array $data): Product;

    public function delete($id): bool;

    public function search(string $query, array $filters = []): LengthAwarePaginator;

    public function getFeaturedProducts(int $limit): Collection;

    public function getCategories(): Collection;
}