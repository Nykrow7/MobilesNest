<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing records that have no slug
        $categories = DB::table('product_categories')
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->get();
            
        foreach ($categories as $category) {
            DB::table('product_categories')
                ->where('id', $category->id)
                ->update(['slug' => Str::slug($category->name)]);
        }
        
        // Then modify the column to have a default value
        Schema::table('product_categories', function (Blueprint $table) {
            // Make the slug column nullable temporarily to avoid issues with existing records
            $table->string('slug')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            // Revert back to non-nullable unique
            $table->string('slug')->nullable(false)->change();
        });
    }
};