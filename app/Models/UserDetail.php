<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{

    protected $fillable = [
        'user_id','mobile_no','address','dob',
        'gender','country','profile_image',
        'last_login_at','ip_address',
        'device_type','timezone', 'is_active',
        'deleted_at', 'created_by','updated_by'
    ];

    
    protected $casts = [
        'dob' => 'date',
        'last_login_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
