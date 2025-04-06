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
        // Check if the table exists before trying to create it
        if (!Schema::hasTable('bulk_pricing_tiers')) {
            Schema::create('bulk_pricing_tiers', function (Blueprint $table) {
                $table->id();
                
                // Check if products table exists before adding foreign key constraint
                if (Schema::hasTable('products')) {
                    $table->foreignId('product_id')->constrained()->onDelete('cascade');
                } else {
                    $table->unsignedBigInteger('product_id');
                }
                
                $table->integer('min_quantity');
                $table->integer('max_quantity')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('discount_percentage', 5, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_pricing_tiers');
    }
};