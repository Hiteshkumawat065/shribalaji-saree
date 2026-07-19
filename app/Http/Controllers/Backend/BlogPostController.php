<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = BlogPost::with('category')->orderByDesc('id');
            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('title', 'like', "%{$q}%")->orWhere('slug', 'like', "%{$q}%");
            }
            $posts = $query->paginate(15);
            return view('backend.blog.posts.index', compact('posts'));
        } catch (Exception $e) {
            Log::error('Blog posts index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load posts.');
        }
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
        return view('backend.blog.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        try {
            $validated['is_published'] = $request->has('is_published');
            $validated['created_by'] = Auth::id();
            $validated['updated_by'] = Auth::id();

            BlogPost::create($validated);
            Log::info('Blog post created', ['title' => $validated['title'], 'slug' => $validated['slug']]);
            return redirect()->route('admin.blog.posts')->with('success', 'Post created.');
        } catch (Exception $e) {
            Log::error('Blog post store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create post.')->withInput();
        }
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
        return view('backend.blog.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        try {
            $validated['is_published'] = $request->has('is_published');
            $validated['updated_by'] = Auth::id();
            $post->update($validated);
            Log::info('Blog post updated', ['post_id' => $post->id]);
            return redirect()->route('admin.blog.posts')->with('success', 'Post updated.');
        } catch (Exception $e) {
            Log::error('Blog post update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update post.')->withInput();
        }
    }
}

