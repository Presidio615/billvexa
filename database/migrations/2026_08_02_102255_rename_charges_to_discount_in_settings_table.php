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
        // Rename charges to discount only if charges exists
        // and discount does not already exist.
        if (
            Schema::hasColumn('settings', 'charges') &&
            !Schema::hasColumn('settings', 'discount')
        ) {
            Schema::table('settings', function (Blueprint $table) {
                $table->renameColumn('charges', 'discount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename discount back to charges only if discount exists
        // and charges does not already exist.
        if (
            Schema::hasColumn('settings', 'discount') &&
            !Schema::hasColumn('settings', 'charges')
        ) {
            Schema::table('settings', function (Blueprint $table) {
                $table->renameColumn('discount', 'charges');
            });
        }
    }
};