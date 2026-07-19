<?php

namespace App\Services;

use App\Models\ContactInquiry;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactService
{
    public function create(array $data): ContactInquiry
    {
        $inquiry = ContactInquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'status' => 'new',
            'created_by' => Auth::id(),
        ]);

        Log::info('Contact inquiry created', ['contact_inquiry_id' => $inquiry->id]);
        return $inquiry;
    }

    public function adminList(array $filters = []): LengthAwarePaginator
    {
        $query = ContactInquiry::query()->orderByDesc('id');

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%");
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(20);
    }
}

