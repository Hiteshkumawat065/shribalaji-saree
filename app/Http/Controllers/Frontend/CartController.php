<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        try {
            $this->cartService->add(auth()->id(), $validated);
            return back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove($id)
    {
        $this->cartService->remove(auth()->id(), $id);
        return back()->with('success', 'Item removed from cart!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateQuantity(auth()->id(), $id, $validated['quantity']);
        return back()->with('success', 'Cart updated!');
    }

    public function clear()
    {
        $this->cartService->clear(auth()->id());
        return redirect()->route('frontend.products.index')->with('success', 'Cart cleared!');
    }
}