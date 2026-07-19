<?php

namespace App\Services;

use App\Models\Review;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ReviewService
{
    public function listForProduct(int $productId, int $perPage = 10): LengthAwarePaginator
    {
        return Review::with('user')
            ->where('product_id', $productId)
            ->where('is_approved', true)
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function createForProduct(int $userId, int $productId, array $data): Review
    {
        $review = Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => (int) $data['rating'],
            'comment' => $data['comment'] ?? null,
            'is_approved' => false,
        ]);

        Log::info('Review submitted', [
            'review_id' => $review->id,
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $review->rating,
        ]);

        return $review;
    }

    public function adminList(array $filters = []): LengthAwarePaginator
    {
        $query = Review::with(['user', 'product'])->orderByDesc('id');

        if (isset($filters['is_approved']) && $filters['is_approved'] !== '') {
            $query->where('is_approved', (bool)$filters['is_approved']);
        }

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($w) use ($q) {
                $w->where('comment', 'like', "%{$q}%")
                    ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$q}%")->orWhere('name', 'like', "%{$q}%"))
                    ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$q}%")->orWhere('sku', 'like', "%{$q}%"));
            });
        }

        return $query->paginate(15);
    }

    public function setApproval(int $reviewId, bool $approved): Review
    {
        $review = Review::findOrFail($reviewId);
        $review->update(['is_approved' => $approved]);

        Log::info('Review approval changed', [
            'review_id' => $reviewId,
            'approved' => $approved,
        ]);

        return $review;
    }

    public function delete(int $reviewId): void
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();
        Log::info('Review deleted', ['review_id' => $reviewId]);
    }
}

