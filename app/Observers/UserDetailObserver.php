<?php

namespace App\Observers;

use App\Models\UserDetail;
use App\Models\UserDetailsLog;
use Illuminate\Support\Facades\Auth;

class UserDetailObserver
{
    /* =====================
        CREATED
    ===================== */
    public function created(UserDetail $detail)
    {
        UserDetailsLog::create([
            'user_detail_id' => $detail->id,
            'mobile_no'      => $detail->mobile_no,
            'address'        => $detail->address,
            'dob'            => $detail->dob,
            'gender'         => $detail->gender,
            'country'        => $detail->country,
            'profile_image'  => $detail->profile_image,
            'last_login_at'  => $detail->last_login_at,
            'ip_address'     => $detail->ip_address,
            'device_type'    => $detail->device_type,
            'is_active'      => $detail->is_active,
            'timezone'       => $detail->timezone,
            'action'         => 'created',
            'deleted_at'     => $detail->deleted_at,
            'created_by'     => Auth::id(),
        ]);
    }

    /* =====================
        UPDATED
    ===================== */
    public function updated(UserDetail $detail)
    {

        $action = 'updated';

         // check if user is inactivated (your custom delete)
        if ($detail->is_active == 0 && $detail->deleted_at == 1) {
            $action = 'deleted';
        }
        UserDetailsLog::create([
            'user_detail_id' => $detail->id,
            'mobile_no'      => $detail->mobile_no,
            'address'        => $detail->address,
            'dob'            => $detail->dob,
            'gender'         => $detail->gender,
            'country'        => $detail->country,
            'profile_image'  => $detail->profile_image,
            'last_login_at'  => $detail->last_login_at,
            'ip_address'     => $detail->ip_address,
            'device_type'    => $detail->device_type,
            'timezone'       => $detail->timezone,
            'is_active'      => $detail->is_active,
            'action'         => $action,
            'deleted_at'      => $detail->deleted_at,
            'updated_by'     => Auth::id(),
        ]);
    }

    /* =====================
        DELETED (Soft Delete)
    ===================== */
    public function deleted(UserDetail $detail)
    {
        UserDetailsLog::create([
            'user_detail_id' => $detail->id,
            'mobile_no'      => $detail->mobile_no,
            'address'        => $detail->address,
            'dob'            => $detail->dob,
            'gender'         => $detail->gender,
            'country'        => $detail->country,
            'profile_image'  => $detail->profile_image,
            'last_login_at'  => $detail->last_login_at,
            'ip_address'     => $detail->ip_address,
            'device_type'    => $detail->device_type,
            'timezone'       => $detail->timezone,
            'is_active'      => $detail->is_active,
            'action'         => 'deleted',
            'deleted_at'      => $detail->deleted_at,
            'created_by'     => Auth::id(),
        ]);
    }
}
