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
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Featured Image
            $table->string('featured_image')->nullable();

            // Stock/Quantity
            $table->integer('total_stock')->default(0);

            // Pricing
            $table->decimal('price', 15, 2);
            $table->decimal('cost_price', 15, 2)->nullable();
            $table->decimal('discount_price', 15, 2)->nullable();

            // Status
            $table->enum('status', [
                'draft',
                'active',
                'inactive',
                'discontinued'
            ])->default('draft');

            // SEO
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Additional flags
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);

            $table->timestamps();

            $table->index('company_id');
            $table->index('category_id');
            $table->index('brand_id');
            $table->index('status');
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
