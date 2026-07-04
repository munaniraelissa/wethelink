<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            return;
        }

        if (!Schema::hasColumn('roles', 'is_protected')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->boolean('is_protected')->default(false)->after('guard_name');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('roles')) {
            return;
        }

        if (Schema::hasColumn('roles', 'is_protected')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('is_protected');
            });
        }
    }
};
