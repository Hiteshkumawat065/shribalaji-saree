<?php

namespace App\Services;

use App\Models\TaxRate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaxService
{
    public function list(): LengthAwarePaginator
    {
        return TaxRate::orderBy('sort_order')->orderByDesc('id')->paginate(20);
    }

    public function getActiveRate(): ?TaxRate
    {
        return TaxRate::where('is_active', true)->orderBy('sort_order')->first();
    }

    public function calculateTax(float $subtotal): float
    {
        $rate = $this->getActiveRate();
        if (!$rate) {
            return 0.0;
        }
        return round($subtotal * ((float)$rate->rate_percent / 100), 2);
    }
}

