<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with(['category', 'variants']);

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['is_featured'])) {
            $query->where('is_featured', $filters['is_featured']);
        }

        $query->listingFilters($filters);

        return $query->paginate(12)->withQueryString();
    }

    public function find($id): Product
    {
        return $this->model->with(['category', 'variants', 'reviews'])->findOrFail($id);
    }

    public function findBySlug(string $slug): Product
    {
        return $this->model->with(['category', 'variants', 'reviews'])->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        $queryObj = $this->model->with(['category', 'variants']);

        if (!empty($query)) {
            $queryObj->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            });
        }

        $queryObj->listingFilters($filters);

        return $queryObj->paginate(12)->withQueryString();
    }

    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return $this->model->where('is_featured', true)
            ->where('is_active', true)
            ->with(['category', 'variants'])
            ->withAvg(['reviews as avg_rating' => fn ($q) => $q->where('is_approved', true)], 'rating')
            ->withCount(['reviews as review_count' => fn ($q) => $q->where('is_approved', true)])
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function getCategories(): Collection
    {
        return Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }
}