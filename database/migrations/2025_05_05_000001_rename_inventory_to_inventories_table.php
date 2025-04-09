<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the inventory table exists and inventories table doesn't exist
        if (Schema::hasTable('inventory') && !Schema::hasTable('inventories')) {
            Schema::rename('inventory', 'inventories');
        }
        // If inventory table doesn't exist but we need inventories table
        else if (!Schema::hasTable('inventory') && !Schema::hasTable('inventories')) {
            Schema::create('inventories', function (Blueprint $table) {
                $table->id();
                
                // Check if products table exists before adding foreign key constraint
                if (Schema::hasTable('products')) {
                    $table->foreignId('product_id')->constrained()->onDelete('cascade');
                } else {
                    $table->unsignedBigInteger('product_id');
                }
                
                $table->integer('quantity')->default(0);
                $table->integer('low_stock_threshold')->default(5);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the inventories table exists
        if (Schema::hasTable('inventories')) {
            // If we're rolling back, rename inventories back to inventory
            if (!Schema::hasTable('inventory')) {
                Schema::rename('inventories', 'inventory');
            } 
            // If inventory already exists, just drop inventories
            else {
                Schema::dropIfExists('inventories');
            }
        }
    }
};