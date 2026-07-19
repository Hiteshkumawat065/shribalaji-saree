<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    public function index()
    {
        try {
            $testimonials = Testimonial::orderBy('sort_order')->orderByDesc('id')->paginate(20);
            return view('backend.testimonials.index', compact('testimonials'));
        } catch (Exception $e) {
            Log::error('Testimonial index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load testimonials.');
        }
    }

    public function create()
    {
        return view('backend.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            Testimonial::create($validated);
            Log::info('Testimonial created', ['name' => $validated['name']]);
            return redirect()->route('admin.testimonials')->with('success', 'Testimonial created.');
        } catch (Exception $e) {
            Log::error('Testimonial store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create testimonial.')->withInput();
        }
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $testimonial->update($validated);
            Log::info('Testimonial updated', ['id' => $testimonial->id]);
            return redirect()->route('admin.testimonials')->with('success', 'Testimonial updated.');
        } catch (Exception $e) {
            Log::error('Testimonial update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update testimonial.')->withInput();
        }
    }
}

