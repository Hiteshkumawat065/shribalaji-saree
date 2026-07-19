<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $searchService;

    public function __construct(ProductService $productService, SearchService $searchService)
    {
        $this->productService = $productService;
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $query = $request->get('q');
        $filters = [
            'category_id' => $request->input('category_id'),
            'price_range' => $request->input('price_range', []),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sort' => $request->input('sort'),
        ];

        $products = $query ? $this->searchService->search($query, $filters) : $this->productService->getAll($filters);
        $categories = $this->productService->getCategories()->loadCount('products');

        $priceRanges = [
            'under_1000' => 'Under &#8377;1000',
            '1000_2000' => '&#8377;1000 – &#8377;2000',
            '2000_3000' => '&#8377;2000 – &#8377;3000',
            'above_3000' => 'Above &#8377;3000',
        ];

        $selectedCategories = array_map('strval', (array) $request->input('category_id', []));
        $selectedPriceRanges = (array) $request->input('price_range', []);

        return view('frontend.products.index', compact(
            'products',
            'categories',
            'priceRanges',
            'selectedCategories',
            'selectedPriceRanges'
        ));
    }

    public function show($slug)
    {
        $product = $this->productService->findBySlug($slug);
        $this->productService->incrementViews($product->id);
        $relatedProducts = $this->searchService->getRelatedProducts($product->id);

        $reviews = $product->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->orderByDesc('id')
            ->paginate(10);

        return view('frontend.products.show', compact('product', 'relatedProducts', 'reviews'));
    }
}