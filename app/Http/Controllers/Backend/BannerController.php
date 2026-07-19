<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Banner::query()->orderBy('position')->orderBy('sort_order')->orderByDesc('id');
            if ($request->filled('position')) {
                $query->where('position', $request->position);
            }
            $banners = $query->paginate(20);
            return view('backend.banners.index', compact('banners'));
        } catch (Exception $e) {
            Log::error('Banner index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load banners.');
        }
    }

    public function create()
    {
        return view('backend.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'position' => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('banners', 'public');
            }
            $validated['is_active'] = $request->has('is_active');
            Banner::create($validated);
            Log::info('Banner created', $validated);
            return redirect()->route('admin.banners')->with('success', 'Banner created.');
        } catch (Exception $e) {
            Log::error('Banner store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create banner.')->withInput();
        }
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'position' => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        try {
            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('banners', 'public');
            }
            $validated['is_active'] = $request->has('is_active');
            $banner->update($validated);
            Log::info('Banner updated', ['id' => $banner->id] + $validated);
            return redirect()->route('admin.banners')->with('success', 'Banner updated.');
        } catch (Exception $e) {
            Log::error('Banner update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update banner.')->withInput();
        }
    }
}

