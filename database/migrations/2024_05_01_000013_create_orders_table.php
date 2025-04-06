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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('order_number')->unique();
                $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'refunded'])->default('pending');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('tax', 10, 2)->default(0);
                $table->decimal('shipping', 10, 2)->default(0);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('total', 10, 2);
                $table->string('payment_method')->nullable();
                $table->string('payment_status')->default('pending');
                $table->text('notes')->nullable();
                $table->text('shipping_address')->nullable();
                $table->text('billing_address')->nullable();
                $table->string('tracking_number')->nullable();
                $table->timestamp('shipped_at')->nullable();
                $table->string('shipping_method')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};