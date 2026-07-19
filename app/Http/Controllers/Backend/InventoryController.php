<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InventoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['q', 'type']);
            $movements = $this->inventoryService->movements($filters);
            return view('backend.inventory.index', compact('movements'));
        } catch (Exception $e) {
            Log::error('Inventory index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load inventory movements.');
        }
    }

    public function adjustForm(Request $request)
    {
        try {
            $products = Product::orderBy('name')->get(['id', 'name', 'sku', 'stock']);
            $selectedProduct = null;
            $variants = collect();

            if ($request->filled('product_id')) {
                $selectedProduct = Product::with('variants')->find($request->product_id);
                $variants = $selectedProduct?->variants ?? collect();
            }

            return view('backend.inventory.adjust', compact('products', 'selectedProduct', 'variants'));
        } catch (Exception $e) {
            Log::error('Inventory adjust form error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load adjust stock page.');
        }
    }

    public function adjust(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'type' => 'required|in:in,out,adjust',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            $this->inventoryService->adjustStock($validated);
            return redirect()->route('admin.inventory')->with('success', 'Stock updated successfully.');
        } catch (Exception $e) {
            Log::error('Inventory adjust error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}

