<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    protected $table = 'inventories';

    protected $fillable = [
        'product_id',
        'quantity',
        'low_stock_threshold'
    ];

    /**
     * Get the product that owns the inventory.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if the product is in stock.
     *
     * @return bool
     */
    public function isInStock()
    {
        return $this->quantity > 0;
    }

    /**
     * Check if the product is low in stock.
     *
     * @return bool
     */
    public function isLowStock()
    {
        return $this->quantity <= $this->low_stock_threshold;
    }

    /**
     * Decrease inventory quantity.
     *
     * @param int $amount
     * @return bool
     */
    public function decreaseStock($amount = 1)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Increase inventory quantity.
     *
     * @param int $amount
     * @return void
     */
    public function increaseStock($amount = 1)
    {
        $this->quantity += $amount;
        $this->save();
    }
}