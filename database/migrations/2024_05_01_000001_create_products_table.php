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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('brand');
                $table->text('description');
                $table->decimal('price', 10, 2);
                $table->string('image')->nullable();
                $table->string('color')->nullable();
                $table->string('storage_capacity')->nullable();
                $table->string('ram')->nullable();
                $table->string('processor')->nullable();
                $table->string('camera')->nullable();
                $table->string('battery')->nullable();
                $table->string('display')->nullable();
                $table->boolean('is_featured')->default(false);
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
        Schema::dropIfExists('products');
    }
};