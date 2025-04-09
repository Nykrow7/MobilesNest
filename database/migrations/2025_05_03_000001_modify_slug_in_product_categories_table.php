<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
            // Drop the unique constraint first
            $table->dropUnique(['slug']);
            
            // Modify the column to be nullable
            $table->string('slug')->nullable()->change();
            
            // Add the unique constraint back
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            // Drop the unique constraint first
            $table->dropUnique(['slug']);
            
            // Revert back to non-nullable
            $table->string('slug')->nullable(false)->change();
            
            // Add the unique constraint back
            $table->unique('slug');
        });
    }
};