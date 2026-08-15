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
        Schema::table('admin_notifications', function (Blueprint $table) {
            // The column already exists in the database,
            // so only create it if it is actually missing.
            if (!Schema::hasColumn('admin_notifications', 'admin_id')) {
                $table->unsignedBigInteger('admin_id')
                    ->nullable()
                    ->after('id');
            }
        });

        // Add the foreign key only after ensuring the column exists.
        Schema::table('admin_notifications', function (Blueprint $table) {
            $table->foreign('admin_id', 'admin_notifications_admin_id_foreign')
                ->references('id')
                ->on('admins')
                ->nullOnDelete();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_notifications', function (Blueprint $table) {
            $table->dropForeign('admin_notifications_admin_id_foreign');
        });

        Schema::table('admin_notifications', function (Blueprint $table) {
            if (Schema::hasColumn('admin_notifications', 'admin_id')) {
                $table->dropColumn('admin_id');
            }
        });
    }
};
