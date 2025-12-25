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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending',      // Order created, waiting for payment
                'paid',         // Payment confirmed
                'processing',   // Being prepared
                'shipped',      // On delivery
                'completed',    // Delivered successfully
                'cancelled'     // Order cancelled
            ])->default('pending');
            
            // Pricing
            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            
            // Customer Details
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address');
            
            // Payment Information
            $table->enum('payment_method', ['qris', 'bank_transfer', 'cod'])->default('qris');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->string('payment_reference')->nullable()->comment('Midtrans transaction ID or QRIS reference');
            $table->string('snap_token')->nullable()->comment('Midtrans Snap token');
            $table->timestamp('paid_at')->nullable();
            
            // Additional Info
            $table->text('notes')->nullable();
            $table->string('coupon_code')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('order_number');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
