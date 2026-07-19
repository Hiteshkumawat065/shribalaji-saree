<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SeoController extends Controller
{
    public function products(Request $request)
    {
        try {
            $query = Product::query()->orderByDesc('id');
            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('name', 'like', "%{$q}%")->orWhere('sku', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            }
            $products = $query->paginate(20);
            return view('backend.seo.products.index', compact('products'));
        } catch (Exception $e) {
            Log::error('SEO products index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load SEO products.');
        }
    }

    public function editProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('backend.seo.products.edit', compact('product'));
        } catch (Exception $e) {
            Log::error('SEO product edit error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load product SEO.');
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:2000',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update($validated);
            Log::info('Product SEO updated', ['product_id' => $product->id]);
            return back()->with('success', 'SEO updated successfully.');
        } catch (Exception $e) {
            Log::error('SEO product update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update SEO.');
        }
    }

    public function categories(Request $request)
    {
        try {
            $query = Category::query()->orderBy('name');
            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('name', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            }
            $categories = $query->paginate(20);
            return view('backend.seo.categories.index', compact('categories'));
        } catch (Exception $e) {
            Log::error('SEO categories index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load SEO categories.');
        }
    }

    public function editCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('backend.seo.categories.edit', compact('category'));
        } catch (Exception $e) {
            Log::error('SEO category edit error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load category SEO.');
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:2000',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update($validated);
            Log::info('Category SEO updated', ['category_id' => $category->id]);
            return back()->with('success', 'SEO updated successfully.');
        } catch (Exception $e) {
            Log::error('SEO category update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update SEO.');
        }
    }
}

