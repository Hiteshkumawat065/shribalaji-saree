<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetailsLog extends Model
{
    protected $table = 'user_details_logs';

    protected $fillable = [
        'user_detail_id',
        'mobile_no',
        'address',
        'dob',
        'gender',
        'country',
        'profile_image',
        'last_login_at',
        'ip_address',
        'device_type',
        'timezone',
        'action',
        'deleted_at',
        'created_by',
        'updated_by' 
    ];
}
