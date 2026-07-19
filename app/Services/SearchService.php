<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        $queryObj = Product::with(['category', 'variants']);

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

    public function autocomplete(string $query)
    {
        return Product::where('is_active', true)
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'image_path']);
    }

    public function getRelatedProducts($productId, int $limit = 4)
    {
        $product = Product::findOrFail($productId);

        return Product::where('id', '!=', $productId)
            ->where('category_id', $product->category_id)
            ->where('is_active', true)
            ->limit($limit)
            ->get();
    }
}