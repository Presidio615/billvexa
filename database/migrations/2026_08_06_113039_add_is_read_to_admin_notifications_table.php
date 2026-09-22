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
        if (!Schema::hasColumn('admin_notifications', 'is_read')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->boolean('is_read')
                    ->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('admin_notifications', 'is_read')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->dropColumn('is_read');
            });
        }
    }
};