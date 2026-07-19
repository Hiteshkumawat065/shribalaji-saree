<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactInquiryController extends Controller
{
    public function index(Request $request, ContactService $contactService)
    {
        try {
            $filters = $request->only(['q', 'status']);
            $inquiries = $contactService->adminList($filters);
            return view('backend.contact_inquiries.index', compact('inquiries'));
        } catch (Exception $e) {
            Log::error('Contact inquiries index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load inquiries.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'admin_note' => 'nullable|string|max:255',
        ]);

        try {
            $inquiry = ContactInquiry::findOrFail($id);
            $inquiry->update($validated);
            Log::info('Contact inquiry updated', ['id' => $inquiry->id] + $validated);
            return back()->with('success', 'Inquiry updated.');
        } catch (Exception $e) {
            Log::error('Contact inquiry update error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update inquiry.');
        }
    }
}

