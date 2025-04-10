<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'shipping_status',
        'shipping_address',
        'recipient_name',
        'recipient_phone',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'shipping_notes',
        'shipping_method',
        'estimated_delivery_date',
        'tracking_number',
        'payment_method',
        'payment_status',
        'notes',
        'shipped_at',
        'delivered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery_date' => 'date',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the transaction for the order.
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Get all transactions for the order.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return app(\App\Helpers\CurrencyHelper::class)->formatPeso($this->total_amount);
    }

    /**
     * Get the formatted discount amount.
     */
    public function getFormattedDiscountAmountAttribute(): string
    {
        return app(\App\Helpers\CurrencyHelper::class)->formatPeso($this->discount_amount);
    }

    /**
     * Get the formatted final amount.
     */
    public function getFormattedFinalAmountAttribute(): string
    {
        return app(\App\Helpers\CurrencyHelper::class)->formatPeso($this->final_amount);
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $color . '">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Get the payment status badge HTML.
     */
    public function getPaymentStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ];

        $color = $colors[$this->payment_status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $color . '">' . ucfirst($this->payment_status) . '</span>';
    }

    /**
     * Get the shipping status badge HTML.
     */
    public function getShippingStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'shipped' => 'bg-blue-100 text-blue-800',
            'delivered' => 'bg-green-100 text-green-800',
        ];

        $color = $colors[$this->shipping_status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $color . '">' . ucfirst($this->shipping_status) . '</span>';
    }

    /**
     * Get the total amount as 'total' for backward compatibility.
     */
    public function getTotalAttribute()
    {
        return $this->total_amount;
    }


}