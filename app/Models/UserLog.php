<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'role',
        'is_email_verify',
        'is_active',
        'action',  
        'deleted_at',
        'created_by',
        'updated_by'
    ];
}
