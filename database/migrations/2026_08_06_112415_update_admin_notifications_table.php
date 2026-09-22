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
        if (!Schema::hasColumn('admin_notifications', 'recipient_type')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->string('recipient_type')
                    ->after('message');
            });
        }

        if (!Schema::hasColumn('admin_notifications', 'recipient_id')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->unsignedBigInteger('recipient_id')
                    ->nullable()
                    ->after('recipient_type');
            });
        }

        if (!Schema::hasColumn('admin_notifications', 'link')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->string('link')
                    ->nullable()
                    ->after('recipient_id');
            });
        }

        if (!Schema::hasColumn('admin_notifications', 'is_read')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->boolean('is_read')
                    ->default(false)
                    ->after('link');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'recipient_type',
            'recipient_id',
            'link',
            'is_read',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('admin_notifications', $column)) {
                Schema::table('admin_notifications', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};