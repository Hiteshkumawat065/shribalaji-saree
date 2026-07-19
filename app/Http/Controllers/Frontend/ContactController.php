<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(Request $request, ContactService $contactService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $contactService->create($validated);
            return back()->with('success', 'Thanks! We have received your inquiry.');
        } catch (Exception $e) {
            Log::error('Contact store error: ' . $e->getMessage());
            return back()->with('error', 'Unable to submit inquiry. Please try again.')->withInput();
        }
    }
}

