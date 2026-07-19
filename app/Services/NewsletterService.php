<?php

namespace App\Services;

use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class NewsletterService
{
    public function subscribe(string $email): NewsletterSubscriber
    {
        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $email],
            [
                'is_active' => true,
                'subscribed_at' => Carbon::now(),
            ]
        );

        Log::info('Newsletter subscribed', ['email' => $email, 'subscriber_id' => $subscriber->id]);
        return $subscriber;
    }

    public function adminList(array $filters = []): LengthAwarePaginator
    {
        $query = NewsletterSubscriber::query()->orderByDesc('id');
        if (!empty($filters['q'])) {
            $query->where('email', 'like', "%{$filters['q']}%");
        }
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', (bool)$filters['is_active']);
        }
        return $query->paginate(20);
    }
}

