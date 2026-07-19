<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ReturnService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
    protected $returnService;

    public function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'nullable|exists:order_items,id',
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:2000',
        ]);

        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to request a return.');
            }

            $this->returnService->createForOrder(
                (int) $validated['order_id'],
                !empty($validated['order_item_id']) ? (int) $validated['order_item_id'] : null,
                $validated
            );

            return back()->with('success', 'Return request submitted successfully.');
        } catch (Exception $e) {
            Log::error('Return request error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}

