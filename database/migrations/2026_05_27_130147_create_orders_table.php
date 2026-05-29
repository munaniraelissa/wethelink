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
            $table->foreignId('company_location_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('order_number')->unique();

            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Financials
            $table->decimal('subtotal', 15, 2);

            $table->decimal('tax', 15, 2)->default(0);

            $table->decimal('shipping_cost', 15, 2)->default(0);

            $table->decimal('discount', 15, 2)->default(0);

            $table->decimal('total', 15, 2);

            // Payment
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            // Order Status
            $table->enum('status', [
                'pending',
                'processing',
                'approved',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Shipping
            $table->string('shipping_name')->nullable();

            $table->string('shipping_phone')->nullable();

            $table->text('shipping_address')->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
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
