<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'min_order_amount',
        'max_uses',
        'current_uses',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'integer',
        'max_uses' => 'integer',
        'current_uses' => 'integer',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}

