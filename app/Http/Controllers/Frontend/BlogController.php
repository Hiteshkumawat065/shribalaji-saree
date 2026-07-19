<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = BlogPost::with('category')
                ->where('is_published', true)
                ->orderByDesc('published_at');

            if ($request->filled('q')) {
                $q = $request->q;
                $query->where('title', 'like', "%{$q}%")->orWhere('excerpt', 'like', "%{$q}%");
            }

            if ($request->filled('category')) {
                $category = BlogCategory::where('slug', $request->category)->first();
                if ($category) {
                    $query->where('blog_category_id', $category->id);
                }
            }

            $posts = $query->paginate(9);
            $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
            return view('frontend.blog.index', compact('posts', 'categories'));
        } catch (Exception $e) {
            Log::error('Frontend blog index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load blog.');
        }
    }

    public function show($slug)
    {
        try {
            $post = BlogPost::with('category')
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();

            $post->increment('views');

            $related = BlogPost::where('is_published', true)
                ->where('id', '!=', $post->id)
                ->when($post->blog_category_id, fn($q) => $q->where('blog_category_id', $post->blog_category_id))
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();

            return view('frontend.blog.show', compact('post', 'related'));
        } catch (Exception $e) {
            Log::error('Frontend blog show error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load post.');
        }
    }
}

