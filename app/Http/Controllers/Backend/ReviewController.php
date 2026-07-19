<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['q', 'is_approved']);
            $reviews = $this->reviewService->adminList($filters);
            return view('backend.reviews.index', compact('reviews'));
        } catch (Exception $e) {
            Log::error('Admin review index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load reviews.');
        }
    }

    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'is_approved' => 'required|in:0,1',
        ]);

        try {
            $this->reviewService->setApproval((int)$id, (bool)$validated['is_approved']);
            return back()->with('success', 'Review updated.');
        } catch (Exception $e) {
            Log::error('Admin review approve error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update review.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->reviewService->delete((int)$id);
            return back()->with('success', 'Review deleted.');
        } catch (Exception $e) {
            Log::error('Admin review delete error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete review.');
        }
    }
}

