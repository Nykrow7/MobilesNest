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
        Schema::table('orders', function (Blueprint $table) {
            // Add shipping details fields if they don't exist
            if (!Schema::hasColumn('orders', 'recipient_name')) {
                $table->string('recipient_name')->nullable()->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'recipient_phone')) {
                $table->string('recipient_phone')->nullable()->after('recipient_name');
            }
            if (!Schema::hasColumn('orders', 'shipping_city')) {
                $table->string('shipping_city')->nullable()->after('recipient_phone');
            }
            if (!Schema::hasColumn('orders', 'shipping_state')) {
                $table->string('shipping_state')->nullable()->after('shipping_city');
            }
            if (!Schema::hasColumn('orders', 'shipping_postal_code')) {
                $table->string('shipping_postal_code')->nullable()->after('shipping_state');
            }
            if (!Schema::hasColumn('orders', 'shipping_country')) {
                $table->string('shipping_country')->nullable()->after('shipping_postal_code');
            }
            if (!Schema::hasColumn('orders', 'shipping_notes')) {
                $table->text('shipping_notes')->nullable()->after('shipping_country');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('shipping_notes');
            }
            if (!Schema::hasColumn('orders', 'estimated_delivery_date')) {
                $table->date('estimated_delivery_date')->nullable()->after('shipping_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('orders', 'recipient_name')) {
                $table->dropColumn('recipient_name');
            }
            if (Schema::hasColumn('orders', 'recipient_phone')) {
                $table->dropColumn('recipient_phone');
            }
            if (Schema::hasColumn('orders', 'shipping_city')) {
                $table->dropColumn('shipping_city');
            }
            if (Schema::hasColumn('orders', 'shipping_state')) {
                $table->dropColumn('shipping_state');
            }
            if (Schema::hasColumn('orders', 'shipping_postal_code')) {
                $table->dropColumn('shipping_postal_code');
            }
            if (Schema::hasColumn('orders', 'shipping_country')) {
                $table->dropColumn('shipping_country');
            }
            if (Schema::hasColumn('orders', 'shipping_notes')) {
                $table->dropColumn('shipping_notes');
            }
            if (Schema::hasColumn('orders', 'shipping_method')) {
                $table->dropColumn('shipping_method');
            }
            if (Schema::hasColumn('orders', 'estimated_delivery_date')) {
                $table->dropColumn('estimated_delivery_date');
            }
        });
    }
};
