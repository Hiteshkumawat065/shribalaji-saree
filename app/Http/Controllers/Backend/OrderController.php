<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orderData  = Order::with('orderDetails')->orderBy('id', 'asc')->get();
            $data['orderData']   = $orderData;
            return view('backend.orders.index', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching orders: ' . $e->getMessage());
        }
    }
}
