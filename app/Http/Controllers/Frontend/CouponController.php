<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CouponService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    protected $couponService;
    protected $cartService;

    public function __construct(CouponService $couponService, CartService $cartService)
    {
        $this->couponService = $couponService;
        $this->cartService = $cartService;
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
        ]);

        try {
            $cart = $this->cartService->getCart();
            $subtotal = $cart instanceof \App\Models\Cart ? (float) $cart->subtotal : (float) $cart->sum('subtotal');

            $coupon = $this->couponService->validateAndGet(trim($validated['code']));
            $discount = $this->couponService->calculateDiscount($coupon, $subtotal);

            $this->cartService->applyCoupon([
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
                'discount_type' => $coupon->discount_type,
                'discount_value' => (float) $coupon->discount_value,
            ]);

            // Recalculate DB cart if user is logged in
            if ($cart instanceof \App\Models\Cart) {
                $this->cartService->recalculateCart($cart);
            }

            return back()->with('success', 'Coupon applied successfully!');
        } catch (Exception $e) {
            Log::error('Coupon apply error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove()
    {
        try {
            $cart = $this->cartService->getCart();
            $this->cartService->removeCoupon();

            if ($cart instanceof \App\Models\Cart) {
                $this->cartService->recalculateCart($cart);
            }

            return back()->with('success', 'Coupon removed.');
        } catch (Exception $e) {
            Log::error('Coupon remove error: ' . $e->getMessage());
            return back()->with('error', 'Unable to remove coupon.');
        }
    }
}

