<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\HomepageSection;
use App\Models\Testimonial;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $sections = HomepageSection::where('is_active', true)->orderBy('sort_order')->get()->keyBy('key');
            $banners = Banner::where('is_active', true)->where('position', 'home_hero')->orderBy('sort_order')->get();
            $offers = Banner::where('is_active', true)->where('position', 'home_offer')->orderBy('sort_order')->limit(3)->get();
            $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(6)->get();

            $productService = app(ProductService::class);
            $featured = $productService->getFeaturedProducts(8);

            if ($featured->isEmpty()) {
                $featured = \App\Models\Product::where('is_active', true)
                    ->with(['category', 'variants'])
                    ->withAvg(['reviews as avg_rating' => fn ($q) => $q->where('is_approved', true)], 'rating')
                    ->withCount(['reviews as review_count' => fn ($q) => $q->where('is_approved', true)])
                    ->orderByDesc('id')
                    ->limit(8)
                    ->get();
            }

            return view('frontend.dashboard', compact('sections', 'banners', 'offers', 'testimonials', 'featured'));
        } catch (\Exception $e) {
            Log::error('Frontend home error: ' . $e->getMessage());
            return view('frontend.dashboard');
        }
    }
}
