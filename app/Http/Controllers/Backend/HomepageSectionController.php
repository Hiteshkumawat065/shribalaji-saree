<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomepageSectionController extends Controller
{
    public function index()
    {
        try {
            $sections = HomepageSection::orderBy('sort_order')->orderBy('id')->get();
            return view('backend.homepage_sections.index', compact('sections'));
        } catch (Exception $e) {
            Log::error('Homepage sections index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load sections.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:homepage_sections,key',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            HomepageSection::create($validated);
            Log::info('Homepage section created', $validated);
            return back()->with('success', 'Section created.');
        } catch (Exception $e) {
            Log::error('Homepage section store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create section.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $section = HomepageSection::findOrFail($id);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $section->update($validated);
            Log::info('Homepage section updated', ['id' => $section->id]);
            return back()->with('success', 'Section updated.');
        } catch (Exception $e) {
            Log::error('Homepage section update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update section.')->withInput();
        }
    }
}

