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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // COMPANY
            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('company_location_id')
                ->nullable()
                ->constrained('company_locations')
                ->nullOnDelete();

            // PERSONAL INFO
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othername')->nullable();

            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('id_number')->unique()->nullable();
            $table->date('date_of_birth')->nullable();

            // CONTACT
            $table->string('telephone')->unique();
            $table->string('alternative_phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // AUTH
            $table->string('password');

            // PROFILE
            $table->string('avatar')->nullable();

            // STATUS
            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'suspended'
            ])->default('pending');

            $table->timestamp('activated_at')->nullable();

            // SECURITY
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();

            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();

            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
