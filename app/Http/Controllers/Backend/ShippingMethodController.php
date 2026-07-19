<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use App\Services\ShippingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingMethodController extends Controller
{
    public function index(ShippingService $shippingService)
    {
        try {
            $methods = $shippingService->list();
            return view('backend.shipping.index', compact('methods'));
        } catch (Exception $e) {
            Log::error('Shipping methods index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load shipping methods.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            ShippingMethod::create($validated);
            Log::info('Shipping method created', $validated);
            return back()->with('success', 'Shipping method created.');
        } catch (Exception $e) {
            Log::error('Shipping method store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create shipping method.');
        }
    }

    public function update(Request $request, $id)
    {
        $method = ShippingMethod::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $method->update($validated);
            Log::info('Shipping method updated', ['id' => $method->id]);
            return back()->with('success', 'Shipping method updated.');
        } catch (Exception $e) {
            Log::error('Shipping method update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update shipping method.');
        }
    }
}

