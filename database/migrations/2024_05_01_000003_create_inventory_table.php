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
        if (!Schema::hasTable('inventory')) {
            Schema::create('inventory', function (Blueprint $table) {
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
        Schema::dropIfExists('inventory');
    }
};