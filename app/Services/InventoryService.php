<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryService
{
    public function movements(array $filters = []): LengthAwarePaginator
    {
        $query = InventoryMovement::with(['product', 'variant', 'creator'])->orderByDesc('id');

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($w) use ($q) {
                $w->where('note', 'like', "%{$q}%")
                    ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$q}%")->orWhere('sku', 'like', "%{$q}%"))
                    ->orWhereHas('variant', fn($v) => $v->where('sku', 'like', "%{$q}%"));
            });
        }

        if (isset($filters['type']) && $filters['type'] !== '') {
            $query->where('type', $filters['type']);
        }

        return $query->paginate(20);
    }

    public function adjustStock(array $data): InventoryMovement
    {
        return DB::transaction(function () use ($data) {
            $type = $data['type'];
            $qty = (int) $data['quantity'];

            if ($qty <= 0) {
                throw new Exception('Quantity must be greater than 0.');
            }

            $productId = (int) $data['product_id'];
            $variantId = !empty($data['product_variant_id']) ? (int) $data['product_variant_id'] : null;

            if ($variantId) {
                $variant = ProductVariant::where('id', $variantId)
                    ->where('product_id', $productId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $before = (int) $variant->stock;
                $after = $this->calculateAfter($before, $type, $qty);

                $variant->update(['stock' => $after]);

                $movement = InventoryMovement::create([
                    'product_id' => $productId,
                    'product_variant_id' => $variantId,
                    'type' => $type,
                    'quantity' => $qty,
                    'before_stock' => $before,
                    'after_stock' => $after,
                    'note' => $data['note'] ?? null,
                    'created_by' => Auth::id(),
                ]);

                Log::info('Inventory adjusted (variant)', [
                    'movement_id' => $movement->id,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'type' => $type,
                    'qty' => $qty,
                    'before' => $before,
                    'after' => $after,
                ]);

                return $movement;
            }

            $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();
            $before = (int) $product->stock;
            $after = $this->calculateAfter($before, $type, $qty);
            $product->update(['stock' => $after]);

            $movement = InventoryMovement::create([
                'product_id' => $productId,
                'product_variant_id' => null,
                'type' => $type,
                'quantity' => $qty,
                'before_stock' => $before,
                'after_stock' => $after,
                'note' => $data['note'] ?? null,
                'created_by' => Auth::id(),
            ]);

            Log::info('Inventory adjusted (product)', [
                'movement_id' => $movement->id,
                'product_id' => $productId,
                'type' => $type,
                'qty' => $qty,
                'before' => $before,
                'after' => $after,
            ]);

            return $movement;
        });
    }

    private function calculateAfter(int $before, string $type, int $qty): int
    {
        $after = match ($type) {
            'in' => $before + $qty,
            'out' => $before - $qty,
            'adjust' => $qty, // set to exact value
            default => throw new Exception('Invalid movement type.'),
        };

        if ($after < 0) {
            throw new Exception('Stock cannot be negative.');
        }

        return $after;
    }
}

