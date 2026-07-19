<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\AdminAlertNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function notifyAdmins(string $title, string $message, array $meta = []): void
    {
        $admins = User::role('superAdmin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminAlertNotification($title, $message, $meta));
        }

        Log::info('Admin notification sent', [
            'title' => $title,
            'message' => $message,
            'meta' => $meta,
            'count' => $admins->count(),
        ]);
    }
}

