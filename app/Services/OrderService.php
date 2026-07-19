<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    protected $repository;
    protected $cartService;

    public function __construct(OrderRepositoryInterface $repository, CartService $cartService)
    {
        $this->repository = $repository;
        $this->cartService = $cartService;
    }

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->all($filters);
    }

    public function find($id): Order
    {
        return $this->repository->find($id);
    }

    public function findByOrderNumber(string $orderNumber): Order
    {
        return $this->repository->findByOrderNumber($orderNumber);
    }

    public function createOrder($userId, $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            $order = $this->repository->create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . time(),
                'subtotal' => $data['subtotal'],
                'tax' => $data['tax'],
                'shipping' => $data['shipping'],
                'discount' => $data['discount'],
                'total' => $data['total'],
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'],
                'shipping_address' => $data['shipping_address'],
                'billing_address' => $data['billing_address'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Deduct stock
                if ($item['product_variant_id']) {
                    ProductVariant::where('id', $item['product_variant_id'])
                        ->decrement('stock', $item['quantity']);
                } else {
                    Product::where('id', $item['product_id'])
                        ->decrement('stock', $item['quantity']);
                }
            }

            // Clear cart
            if ($userId) {
                $cart = Cart::where('user_id', $userId)->first();
                if ($cart) {
                    $cart->items()->delete();
                    $cart->delete();
                }
            } else {
                \Illuminate\Support\Facades\Session::forget('cart');
            }

            // Coupon usage (if applied)
            $coupon = \Illuminate\Support\Facades\Session::get('applied_coupon');
            if (!empty($coupon['coupon_id'])) {
                try {
                    $couponModel = \App\Models\Coupon::find($coupon['coupon_id']);
                    if ($couponModel) {
                        $couponModel->increment('current_uses');
                        \Log::info('Coupon usage incremented', ['coupon_id' => $couponModel->id, 'code' => $couponModel->code]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Coupon usage increment error: ' . $e->getMessage());
                }
            }
            \Illuminate\Support\Facades\Session::forget('applied_coupon');

            return $order;
        });
    }

    public function updateStatus($id, array $data): Order
    {
        return $this->repository->update($id, $data);
    }

    public function getUserOrders($userId): LengthAwarePaginator
    {
        return $this->repository->getUserOrders($userId);
    }

    public function getPendingOrders()
    {
        return $this->repository->getPendingOrders();
    }

    public function getTotalRevenue(): float
    {
        return $this->repository->getTotalRevenue();
    }

    public function getRecentOrders(int $limit = 10)
    {
        return $this->repository->getRecentOrders($limit);
    }

    public function sendOrderConfirmation(Order $order)
    {
        // Implement email sending logic here
        // Mail::to($order->user->email)->send(new OrderConfirmation($order));
    }

    public function processPayment($orderId, $paymentData)
    {
        $order = $this->find($orderId);
        $order->update([
            'payment_status' => 'paid',
        ]);

        // Create payment record
        $order->payment()->create([
            'payment_method' => $paymentData['method'],
            'transaction_id' => $paymentData['transaction_id'],
            'amount' => $order->total,
            'status' => 'completed',
            'payment_details' => $paymentData,
        ]);

        return $order;
    }
}