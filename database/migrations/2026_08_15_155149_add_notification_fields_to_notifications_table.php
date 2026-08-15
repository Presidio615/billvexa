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
        Schema::table('notifications', function (Blueprint $table) {

            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->nullable()->after('message');
            }

            if (!Schema::hasColumn('notifications', 'icon')) {
                $table->string('icon')->nullable()->after('type');
            }

            if (!Schema::hasColumn('notifications', 'icon_class')) {
                $table->string('icon_class')->nullable()->after('icon');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {

            if (Schema::hasColumn('notifications', 'icon_class')) {
                $table->dropColumn('icon_class');
            }

            if (Schema::hasColumn('notifications', 'icon')) {
                $table->dropColumn('icon');
            }

            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }

        });
    }
};
