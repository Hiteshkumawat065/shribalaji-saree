<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->orderByDesc('created_at')->paginate(20);
            $unreadCount = $user->unreadNotifications()->count();

            return view('backend.notifications.index', compact('notifications', 'unreadCount'));
        } catch (Exception $e) {
            Log::error('Admin notifications index error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load notifications.');
        }
    }

    public function markRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->where('id', $id)->firstOrFail();
            $notification->markAsRead();
            return back()->with('success', 'Notification marked as read.');
        } catch (Exception $e) {
            Log::error('Admin notification markRead error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update notification.');
        }
    }

    public function markAllRead()
    {
        try {
            Auth::user()->unreadNotifications->markAsRead();
            return back()->with('success', 'All notifications marked as read.');
        } catch (Exception $e) {
            Log::error('Admin notification markAllRead error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update notifications.');
        }
    }
}

