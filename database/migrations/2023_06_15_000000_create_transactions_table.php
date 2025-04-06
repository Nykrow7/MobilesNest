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
        if (!Schema::hasTable('transactions')) {
            // Ensure orders table exists before creating transactions table
            if (Schema::hasTable('orders')) {
                Schema::create('transactions', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('order_id')->constrained()->onDelete('cascade');
                    $table->string('transaction_number')->unique();
                    $table->decimal('amount', 10, 2);
                    $table->string('payment_method');
                    $table->string('status')->default('pending');
                    $table->json('payment_details')->nullable();
                    $table->timestamps();
                });
            } else {
                // Create transactions table without foreign key constraint
                Schema::create('transactions', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('order_id');
                    $table->string('transaction_number')->unique();
                    $table->decimal('amount', 10, 2);
                    $table->string('payment_method');
                    $table->string('status')->default('pending');
                    $table->json('payment_details')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};