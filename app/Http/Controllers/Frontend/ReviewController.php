<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to submit a review.');
            }

            $this->reviewService->createForProduct(Auth::id(), (int)$productId, $validated);
            return back()->with('success', 'Thanks! Your review has been submitted for approval.');
        } catch (Exception $e) {
            Log::error('Review submit error: ' . $e->getMessage());
            return back()->with('error', 'Unable to submit review. Please try again.');
        }
    }
}

