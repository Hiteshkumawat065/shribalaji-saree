<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function getCart()
    {
        $userId = Auth::id();

        if ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) {
                $cart = Cart::create(['user_id' => $userId]);
            }
            return $cart->load('items.product', 'items.variant');
        } else {
            $cartItems = collect(Session::get('cart', []));
            return $cartItems->map(function ($item) {
                $product = Product::find($item['product_id']);
                return (object) [
                    'id' => $item['product_id'],
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ];
            });
        }
    }

    public function add($userId, array $data)
    {
        $product = Product::findOrFail($data['product_id']);
        $variant = isset($data['variant_id']) ? ProductVariant::find($data['variant_id']) : null;

        if ($variant && $variant->stock < $data['quantity']) {
            throw new \Exception('Insufficient stock for variant');
        }

        if (!$variant && $product->stock < $data['quantity']) {
            throw new \Exception('Insufficient stock for product');
        }

        if ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) {
                $cart = Cart::create(['user_id' => $userId]);
            }

            $cartItem = CartItem::updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                ],
                [
                    'quantity' => $data['quantity'],
                    'price' => $variant ? $variant->price : $product->price,
                    'subtotal' => $data['quantity'] * ($variant ? $variant->price : $product->price),
                ]
            );

            $this->recalculateCart($cart);
            return $cart->load('items.product', 'items.variant');
        } else {
            $cart = Session::get('cart', []);
            $key = $variant ? $product->id . '_' . $variant->id : $product->id;

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $data['quantity'];
            } else {
                $cart[$key] = [
                    'product_id' => $product->id,
                    'variant_id' => $variant?->id,
                    'quantity' => $data['quantity'],
                    'price' => $variant ? $variant->price : $product->price,
                ];
            }

            Session::put('cart', $cart);
            return collect($cart);
        }
    }

    public function remove($userId, $cartItemId)
    {
        if ($userId) {
            $cartItem = CartItem::where('id', $cartItemId)
                ->whereHas('cart', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->first();
            if ($cartItem) {
                $cartItem->delete();
                $cart = Cart::where('user_id', $userId)->first();
                if ($cart) {
                    $this->recalculateCart($cart);
                }
            }
            return true;
        } else {
            $cart = Session::get('cart', []);
            $key = $cartItemId;
            if (isset($cart[$key])) {
                unset($cart[$key]);
                Session::put('cart', $cart);
            }
            return true;
        }
    }

    public function updateQuantity($userId, $cartItemId, $quantity)
    {
        if ($userId) {
            $cartItem = CartItem::where('id', $cartItemId)
                ->whereHas('cart', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->first();
            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $quantity,
                    'subtotal' => $quantity * $cartItem->price,
                ]);
                $cart = Cart::where('user_id', $userId)->first();
                if ($cart) {
                    $this->recalculateCart($cart);
                }
            }
            return true;
        }
        return false;
    }

    public function recalculateCart($cart)
    {
        $items = $cart->items;
        $subtotal = $items->sum('subtotal');
        $tax = $subtotal * 0.08; // 8% tax
        $discount = 0;
        $coupon = Session::get('applied_coupon');
        if (!empty($coupon['discount'])) {
            $discount = (float) $coupon['discount'];
        }
        $total = $subtotal + $tax - $discount;

        $cart->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    public function clear($userId)
    {
        if ($userId) {
            CartItem::where('cart_id', Cart::where('user_id', $userId)->value('id'))->delete();
            Cart::where('user_id', $userId)->delete();
        } else {
            Session::forget('cart');
        }

        Session::forget('applied_coupon');
    }

    public function applyCoupon(array $couponData): void
    {
        Session::put('applied_coupon', $couponData);
        Log::info('Coupon applied to cart session', $couponData);
    }

    public function removeCoupon(): void
    {
        Session::forget('applied_coupon');
        Log::info('Coupon removed from cart session');
    }

    public function getCartCount($userId)
    {
        if ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            return $cart ? $cart->items->sum('quantity') : 0;
        } else {
            $cart = Session::get('cart', []);
            return collect($cart)->sum('quantity');
        }
    }
}