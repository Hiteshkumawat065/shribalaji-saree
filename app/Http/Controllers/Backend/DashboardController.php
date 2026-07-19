<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $orderService;
    protected $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $pendingOrders = $this->orderService->getPendingOrders();
            $pendingOrdersCount = $pendingOrders->count();
            $totalRevenue = $this->orderService->getTotalRevenue();
            $totalProducts = $this->productService->getTotalProducts();
            $totalUsers = User::count();
            $recentOrders = $this->orderService->getRecentOrders(8);

            return view('backend.dashboard', compact(
                'pendingOrdersCount',
                'totalRevenue',
                'totalProducts',
                'totalUsers',
                'recentOrders'
            ));
        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage());
            return view('backend.dashboard');
        }
    }
}
