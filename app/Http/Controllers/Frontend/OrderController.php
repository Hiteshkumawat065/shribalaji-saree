<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to view your orders.');
            }

            $orders = $this->orderService->getUserOrders(Auth::id());
            return view('frontend.orders.index', compact('orders'));
        } catch (Exception $e) {
            Log::error('Frontend Order Index Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading orders.');
        }
    }

    public function show($id)
    {
        try {
            $order = $this->orderService->find($id);

            // Basic authorization: guest checkout orders could exist (user_id null),
            // but if logged in, ensure user can only view own order.
            if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
                return redirect()->route('orders.index')->with('error', 'You are not allowed to view this order.');
            }

            return view('frontend.orders.show', compact('order'));
        } catch (Exception $e) {
            Log::error('Frontend Order Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load order details.');
        }
    }
}

