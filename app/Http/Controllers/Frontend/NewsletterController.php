<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\NewsletterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request, NewsletterService $newsletterService)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $newsletterService->subscribe($validated['email']);
            return back()->with('success', 'Subscribed successfully!');
        } catch (Exception $e) {
            Log::error('Newsletter subscribe error: ' . $e->getMessage());
            return back()->with('error', 'Unable to subscribe. Please try again.');
        }
    }
}

