<?php

namespace App\Services;

use App\Models\Coupon;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CouponService
{
    public function validateAndGet(string $code): Coupon
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();

        if (!$coupon->is_active) {
            throw new Exception('Coupon is inactive.');
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw new Exception('Coupon has expired.');
        }

        if ($coupon->max_uses !== null && $coupon->current_uses >= $coupon->max_uses) {
            throw new Exception('Coupon usage limit reached.');
        }

        return $coupon;
    }

    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->min_order_amount !== null && $subtotal < (float)$coupon->min_order_amount) {
            throw new Exception('Order amount is below minimum for this coupon.');
        }

        if ($coupon->discount_type === 'percentage') {
            return round(($subtotal * ((float)$coupon->discount_value / 100)), 2);
        }

        return min(round((float)$coupon->discount_value, 2), $subtotal);
    }

    public function incrementUsage(Coupon $coupon): void
    {
        $coupon->increment('current_uses');
        Log::info('Coupon used', ['coupon_id' => $coupon->id, 'code' => $coupon->code]);
    }
}

