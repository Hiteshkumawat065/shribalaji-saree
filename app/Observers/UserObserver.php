<?php

namespace App\Observers;

use App\Models\User; 
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        UserLog::create([
            'user_id'         => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'role'            => $user->role,
            'is_email_verify' => $user->is_email_verify,
            'is_active'       => $user->is_active,
            'action'          => 'created',
            'deleted_at'      => $user->deleted_at,
            'created_by'      => Auth::id(),
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $action = 'updated';

         // check if user is inactivated (your custom delete)
        if ($user->is_active == 0 && $user->deleted_at == 1) {
            $action = 'deleted';
        }

        UserLog::create([
            'user_id'         => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'role'            => $user->role,
            'is_email_verify' => $user->is_email_verify,
            'is_active'       => $user->is_active,
            'action'          => $action,
            'deleted_at'      => $user->deleted_at,
            'created_by'      => Auth::id(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        UserLog::create([
            'user_id'         => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'role'            => $user->role,
            'is_email_verify' => $user->is_email_verify,
            'is_active'       => $user->is_active,
            'action'          => 'deleted',
            'deleted_at'      => $user->deleted_at,
            'created_by'      => Auth::id(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
