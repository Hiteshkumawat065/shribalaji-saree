<?php

namespace App\Services;

use App\Models\ShippingMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ShippingService
{
    public function list(): LengthAwarePaginator
    {
        return ShippingMethod::orderBy('sort_order')->orderByDesc('id')->paginate(20);
    }

    public function getActiveMethods()
    {
        return ShippingMethod::where('is_active', true)->orderBy('sort_order')->get();
    }

    public function resolveCost(?int $methodId, float $subtotal): float
    {
        $method = null;
        if ($methodId) {
            $method = ShippingMethod::where('is_active', true)->find($methodId);
        }
        if (!$method) {
            $method = ShippingMethod::where('is_active', true)->orderBy('sort_order')->first();
        }
        if (!$method) {
            return 0.0;
        }

        if ($method->min_order_amount !== null && $subtotal >= (float)$method->min_order_amount) {
            return 0.0;
        }

        return (float) $method->cost;
    }
}

