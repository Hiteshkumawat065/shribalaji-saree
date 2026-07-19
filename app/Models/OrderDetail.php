<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'sku',
        'price',
        'color',
        'size',
        'fabric',
        'quantity',
        'unit_price',
        'tax_amount',
        'discount_amount',
        'total_price',
        'attributes',
        'item_status',
        'is_refunded',
        'refund_amount',
        'is_active',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];
}