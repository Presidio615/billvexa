<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the admin_id column only if it does not already exist.
        if (!Schema::hasColumn('admin_notifications', 'admin_id')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_id')
                    ->nullable()
                    ->after('id');
            });
        }

        // Check whether the foreign key already exists.
        $foreignKeyExists = DB::selectOne("
            SELECT COUNT(*) AS count
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'admin_notifications'
              AND CONSTRAINT_NAME = 'admin_notifications_admin_id_foreign'
        ");

        // Create the foreign key only if it does not already exist.
        if (!$foreignKeyExists || $foreignKeyExists->count == 0) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->foreign('admin_id', 'admin_notifications_admin_id_foreign')
                    ->references('id')
                    ->on('admins')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $foreignKeyExists = DB::selectOne("
            SELECT COUNT(*) AS count
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'admin_notifications'
              AND CONSTRAINT_NAME = 'admin_notifications_admin_id_foreign'
        ");

        if ($foreignKeyExists && $foreignKeyExists->count > 0) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->dropForeign('admin_notifications_admin_id_foreign');
            });
        }

        if (Schema::hasColumn('admin_notifications', 'admin_id')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->dropColumn('admin_id');
            });
        }
    }
};