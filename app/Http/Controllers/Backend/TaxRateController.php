<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use App\Services\TaxService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaxRateController extends Controller
{
    public function index(TaxService $taxService)
    {
        try {
            $rates = $taxService->list();
            return view('backend.tax.index', compact('rates'));
        } catch (Exception $e) {
            Log::error('Tax rates index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load tax rates.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate_percent' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            TaxRate::create($validated);
            Log::info('Tax rate created', $validated);
            return back()->with('success', 'Tax rate created.');
        } catch (Exception $e) {
            Log::error('Tax rate store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create tax rate.');
        }
    }

    public function update(Request $request, $id)
    {
        $rate = TaxRate::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate_percent' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $rate->update($validated);
            Log::info('Tax rate updated', ['id' => $rate->id]);
            return back()->with('success', 'Tax rate updated.');
        } catch (Exception $e) {
            Log::error('Tax rate update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update tax rate.');
        }
    }
}

