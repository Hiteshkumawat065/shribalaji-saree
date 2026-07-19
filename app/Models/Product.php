<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'sku',
        'price',
        'compare_price',
        'stock',
        'image_path',
        'images',
        'category_id',
        'brand_id',
        'is_active',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock' => 'integer',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'views' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'price', 'stock', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Product {$eventName}");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeListingFilters($query, array $filters = [])
    {
        $categoryIds = $filters['category_id'] ?? null;
        if ($categoryIds !== null && $categoryIds !== '') {
            $categoryIds = array_filter(array_map('intval', (array) $categoryIds));
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        $priceRanges = $filters['price_range'] ?? [];
        if (!is_array($priceRanges)) {
            $priceRanges = array_filter([$priceRanges]);
        }

        $allowedRanges = ['under_1000', '1000_2000', '2000_3000', 'above_3000'];
        $priceRanges = array_values(array_intersect($priceRanges, $allowedRanges));

        if (!empty($priceRanges)) {
            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    $q->orWhere(function ($sub) use ($range) {
                        match ($range) {
                            'under_1000' => $sub->where('price', '<', 1000),
                            '1000_2000' => $sub->whereBetween('price', [1000, 2000]),
                            '2000_3000' => $sub->whereBetween('price', [2000, 3000]),
                            'above_3000' => $sub->where('price', '>', 3000),
                            default => null,
                        };
                    });
                }
            });
        } else {
            if (isset($filters['min_price']) && $filters['min_price'] !== '') {
                $query->where('price', '>=', $filters['min_price']);
            }

            if (isset($filters['max_price']) && $filters['max_price'] !== '') {
                $query->where('price', '<=', $filters['max_price']);
            }
        }

        if (($filters['sort'] ?? '') === 'price') {
            $query->orderBy('price', $filters['order'] ?? 'asc');
        }

        return $query;
    }
}