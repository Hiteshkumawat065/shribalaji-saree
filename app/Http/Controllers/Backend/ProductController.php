<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'is_active', 'is_featured']);
        $productData = $this->productService->getAll($filters);

        return view('backend.products.index', compact('productData'));
    }

    public function create()
    {
        $categories = $this->productService->getCategories();
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $this->productService->create($validated);

        return redirect()->route('admin.products')
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        $categories = $this->productService->getCategories();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('products', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $this->productService->update($id, $validated);

        return redirect()->route('admin.products')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->productService->delete($id);
        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Server-side search (also fixes route collision when "search" was matched as an id).
     */
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $filters = $request->only(['category_id', 'is_active', 'is_featured']);

        $productData = $q !== ''
            ? $this->productService->search($q, $filters)
            : $this->productService->getAll($filters);

        return view('backend.products.index', compact('productData'));
    }

    public function toggleStatus($id)
    {
        $product = $this->productService->find($id);
        $this->productService->update($id, ['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated.');
    }

    public function toggleFeatured($id)
    {
        $product = $this->productService->find($id);
        $this->productService->update($id, ['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Featured flag updated.');
    }
}