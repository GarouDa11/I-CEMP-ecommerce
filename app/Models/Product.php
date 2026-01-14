<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'stock',
        'sold_count',
        'material',
        'size',
        'weight',
        'category',
        'committee_id',
        'main_image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Add this accessor for images
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->main_image) {
                    return 'https://via.placeholder.com/300?text=No+Image';
                }
                
                // If it's already a full URL, return it
                if (str_starts_with($this->main_image, 'http')) {
                    return $this->main_image;
                }
                
                // Otherwise, it's in storage
                return asset('storage/' . $this->main_image);
            }
        );
    }

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function getDiscountPercentage()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function isLikedBy($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }
}