<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'description',
        'price',
        'stock_quantity',
        'ram',
        'storage',
        'processor',
        'camera',
        'battery',
        'display',
        'os',
        'is_5g',
        'additional_specs',
        'is_featured',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_5g' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'additional_specs' => 'array',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get all images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get the URL for the product.
     */
    public function getUrlAttribute(): string
    {
        return route('products.show', $this->slug);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Get the bulk pricing tiers for the product.
     */
    public function bulkPricingTiers(): HasMany
    {
        return $this->hasMany(BulkPricingTier::class);
    }
    
    /**
     * Get the applicable bulk pricing tier for a given quantity.
     *
     * @param int $quantity
     * @return BulkPricingTier|null
     */
    public function getApplicableBulkPricingTier(int $quantity): ?BulkPricingTier
    {
        return BulkPricingTier::getApplicableTier($this->id, $quantity);
    }
    
    /**
     * Get the price for a given quantity, taking bulk pricing into account.
     *
     * @param int $quantity
     * @return float
     */
    public function getPriceForQuantity(int $quantity): float
    {
        $tier = $this->getApplicableBulkPricingTier($quantity);
        
        if ($tier) {
            return $tier->price;
        }
        
        return $this->price;
    }
}