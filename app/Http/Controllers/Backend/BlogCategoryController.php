<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = BlogCategory::query()->orderBy('sort_order')->orderBy('id', 'desc');
            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('name', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            }
            $categories = $query->paginate(15);
            return view('backend.blog.categories.index', compact('categories'));
        } catch (Exception $e) {
            Log::error('Blog category index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load blog categories.');
        }
    }

    public function create()
    {
        return view('backend.blog.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            BlogCategory::create($validated);
            Log::info('Blog category created', $validated);
            return redirect()->route('admin.blog.categories')->with('success', 'Category created.');
        } catch (Exception $e) {
            Log::error('Blog category store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create category.')->withInput();
        }
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('backend.blog.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $category->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $category->update($validated);
            Log::info('Blog category updated', ['id' => $category->id] + $validated);
            return redirect()->route('admin.blog.categories')->with('success', 'Category updated.');
        } catch (Exception $e) {
            Log::error('Blog category update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update category.')->withInput();
        }
    }
}

