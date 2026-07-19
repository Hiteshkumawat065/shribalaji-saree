<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Services\NewsletterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request, NewsletterService $newsletterService)
    {
        try {
            $filters = $request->only(['q', 'is_active']);
            $subscribers = $newsletterService->adminList($filters);
            return view('backend.newsletter.index', compact('subscribers'));
        } catch (Exception $e) {
            Log::error('Newsletter admin index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load subscribers.');
        }
    }

    public function toggle(Request $request, $id)
    {
        try {
            $subscriber = NewsletterSubscriber::findOrFail($id);
            $subscriber->update(['is_active' => !$subscriber->is_active]);
            Log::info('Newsletter subscriber toggled', ['id' => $subscriber->id, 'is_active' => $subscriber->is_active]);
            return back()->with('success', 'Subscriber updated.');
        } catch (Exception $e) {
            Log::error('Newsletter toggle error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update subscriber.');
        }
    }
}

