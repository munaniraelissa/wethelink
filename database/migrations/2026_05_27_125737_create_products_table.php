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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->unique();

            $table->string('barcode')->nullable();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            // Pricing
            $table->decimal('price', 15, 2);

            $table->decimal('discount_price', 15, 2)->nullable();

            $table->decimal('cost_price', 15, 2)->nullable();

            // Inventory
            $table->integer('quantity')->default(0);

            $table->integer('minimum_order_quantity')->default(1);

            // Product details
            $table->string('unit')->default('pcs');

            $table->decimal('weight', 10, 2)->nullable();

            // Status
            $table->enum('status', [
                'draft',
                'published',
                'out_of_stock',
                'inactive'
            ])->default('draft');

            $table->boolean('is_featured')->default(false);

            $table->integer('views')->default(0);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
