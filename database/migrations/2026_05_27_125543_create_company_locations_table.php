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
        Schema::create('company_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('email')->nullable();

            $table->string('telephone')->nullable();

            $table->string('manager_name')->nullable();

            // Address
            $table->string('country')->nullable();

            $table->string('province')->nullable();

            $table->string('district')->nullable();

            $table->string('city')->nullable();

            $table->text('address')->nullable();

            // GPS
            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_head_office')->default(false);

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_locations');
    }
};
