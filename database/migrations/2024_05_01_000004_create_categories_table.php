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
        // Check if the categories table exists before trying to create it
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Create pivot table for product categories if it doesn't exist
        if (!Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                
                // Check if categories table exists before adding foreign key constraint
                if (Schema::hasTable('categories')) {
                    $table->foreignId('category_id')->constrained()->onDelete('cascade');
                } else {
                    $table->unsignedBigInteger('category_id');
                }
                
                // Check if products table exists before adding foreign key constraint
                if (Schema::hasTable('products')) {
                    $table->foreignId('product_id')->constrained()->onDelete('cascade');
                } else {
                    $table->unsignedBigInteger('product_id');
                }
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
    }
};