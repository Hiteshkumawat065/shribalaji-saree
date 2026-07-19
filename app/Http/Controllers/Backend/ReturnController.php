<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ReturnService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReturnController extends Controller
{
    protected $returnService;

    public function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['q', 'status']);
            $returns = $this->returnService->adminList($filters);
            return view('backend.returns.index', compact('returns'));
        } catch (Exception $e) {
            Log::error('Admin returns index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load returns.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:requested,approved,rejected,refunded,closed',
            'refund_amount' => 'nullable|numeric|min:0',
            'refund_method' => 'nullable|string|max:50',
            'admin_note' => 'nullable|string|max:255',
        ]);

        try {
            $this->returnService->updateStatus((int)$id, $validated);
            return back()->with('success', 'Return updated.');
        } catch (Exception $e) {
            Log::error('Admin return update error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}

