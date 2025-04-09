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
        Schema::table('products', function (Blueprint $table) {
            // Add the 'os' column if it doesn't exist
            if (!Schema::hasColumn('products', 'os')) {
                $table->string('os')->nullable()->after('camera');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the 'os' column if it exists
            if (Schema::hasColumn('products', 'os')) {
                $table->dropColumn('os');
            }
        });
    }
};