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
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->unique()->after('slug');
            }
            
            if (!Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode')->nullable()->after('sku');
            }
            
            if (!Schema::hasColumn('products', 'short_description')) {
                $table->text('short_description')->nullable()->after('barcode');
            }
            
            if (!Schema::hasColumn('products', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            
            if (!Schema::hasColumn('products', 'view_count')) {
                $table->integer('view_count')->default(0)->after('is_featured');
            }
            
            if (!Schema::hasColumn('products', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('view_count');
            }
            
            if (!Schema::hasColumn('products', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            
            if (Schema::hasColumn('products', 'barcode')) {
                $table->dropColumn('barcode');
            }
            
            if (Schema::hasColumn('products', 'short_description')) {
                $table->dropColumn('short_description');
            }
            
            if (Schema::hasColumn('products', 'featured_image')) {
                $table->dropColumn('featured_image');
            }
            
            if (Schema::hasColumn('products', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            
            if (Schema::hasColumn('products', 'view_count')) {
                $table->dropColumn('view_count');
            }
            
            if (Schema::hasColumn('products', 'meta_description')) {
                $table->dropColumn('meta_description');
            }
            
            if (Schema::hasColumn('products', 'meta_keywords')) {
                $table->dropColumn('meta_keywords');
            }
        });
    }
};
