<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get cart for the current user or session.
     */
    public static function getCurrentCart($userId = null, $sessionId = null)
    {
        if ($userId) {
            return self::firstOrCreate(['user_id' => $userId], ['total_amount' => 0]);
        } elseif ($sessionId) {
            return self::firstOrCreate(['session_id' => $sessionId], ['total_amount' => 0]);
        }
        
        return null;
    }

    /**
     * Update cart total amount based on cart items.
     */
    public function updateTotalAmount()
    {
        $this->total_amount = $this->items->sum('subtotal');
        $this->save();
        
        return $this;
    }
}