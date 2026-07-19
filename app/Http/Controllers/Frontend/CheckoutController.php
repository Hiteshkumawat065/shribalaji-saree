<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ShippingService;
use App\Services\TaxService;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $shippingService;
    protected $taxService;

    public function __construct(CartService $cartService, OrderService $orderService, ShippingService $shippingService, TaxService $taxService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->shippingService = $shippingService;
        $this->taxService = $taxService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $subtotal = $cart instanceof \App\Models\Cart ? (float) $cart->subtotal : (float) $cart->sum('subtotal');
        $discount = 0;
        $coupon = \Illuminate\Support\Facades\Session::get('applied_coupon');
        if (!empty($coupon['discount'])) {
            $discount = (float) $coupon['discount'];
        }

        $shippingMethods = $this->shippingService->getActiveMethods();
        $selectedShippingId = request('shipping_method_id');
        $shipping = $this->shippingService->resolveCost($selectedShippingId ? (int)$selectedShippingId : null, $subtotal);
        $tax = $this->taxService->calculateTax($subtotal);
        $total = max(0, ($subtotal + $tax + $shipping - $discount));

        return view('frontend.checkout.index', compact('cart', 'total', 'shippingMethods', 'shipping', 'tax', 'discount'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|in:cod,stripe',
            'shipping_method_id' => 'nullable|exists:shipping_methods,id',
        ]);

        $cart = $this->cartService->getCart();

        if ($cart->isEmpty()) {
            return back()->with('error', 'Cart is empty!');
        }

        $subtotal = $cart->sum('subtotal');
        $tax = $this->taxService->calculateTax($subtotal);
        $shipping = $this->shippingService->resolveCost(!empty($validated['shipping_method_id']) ? (int)$validated['shipping_method_id'] : null, $subtotal);
        $discount = 0;
        $coupon = \Illuminate\Support\Facades\Session::get('applied_coupon');
        if (!empty($coupon['discount'])) {
            $discount = (float) $coupon['discount'];
        }
        $total = max(0, ($subtotal + $tax + $shipping - $discount));

        $items = [];
        foreach ($cart as $item) {
            $items[] = [
                'product_id' => $item->product->id,
                'product_variant_id' => $item->variant?->id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
            ];
        }

        try {
            $order = $this->orderService->createOrder(auth()->id(), [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'notes' => null,
                'items' => $items,
            ]);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Order failed. Please try again.');
        }
    }
}