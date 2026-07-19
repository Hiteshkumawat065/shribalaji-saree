<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class WishlistService
{
    public function listForUser(int $userId): LengthAwarePaginator
    {
        return Wishlist::with(['product.category'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(12);
    }

    public function toggle(int $userId, int $productId): bool
    {
        Product::findOrFail($productId);

        $existing = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($existing) {
            $existing->delete();
            Log::info('Wishlist removed', ['user_id' => $userId, 'product_id' => $productId]);
            return false;
        }

        Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
        Log::info('Wishlist added', ['user_id' => $userId, 'product_id' => $productId]);
        return true;
    }

    public function remove(int $userId, int $wishlistId): void
    {
        $wishlist = Wishlist::where('id', $wishlistId)->where('user_id', $userId)->firstOrFail();
        $wishlist->delete();
        Log::info('Wishlist item deleted', ['user_id' => $userId, 'wishlist_id' => $wishlistId]);
    }
}

