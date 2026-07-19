<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\WishlistService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function index()
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to view wishlist.');
            }

            $wishlists = $this->wishlistService->listForUser(Auth::id());
            return view('frontend.wishlist.index', compact('wishlists'));
        } catch (Exception $e) {
            Log::error('Wishlist index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load wishlist.');
        }
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to use wishlist.');
            }

            $added = $this->wishlistService->toggle(Auth::id(), (int)$validated['product_id']);
            return back()->with('success', $added ? 'Added to wishlist!' : 'Removed from wishlist!');
        } catch (Exception $e) {
            Log::error('Wishlist toggle error: ' . $e->getMessage());
            return back()->with('error', 'Wishlist action failed.');
        }
    }

    public function destroy($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.showLoginForm')->with('error', 'Please login to continue.');
            }

            $this->wishlistService->remove(Auth::id(), (int)$id);
            return back()->with('success', 'Removed from wishlist.');
        } catch (Exception $e) {
            Log::error('Wishlist delete error: ' . $e->getMessage());
            return back()->with('error', 'Unable to remove item.');
        }
    }
}

