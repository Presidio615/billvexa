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
        Schema::table('transactions', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('transactions', 'discount')) {
                $table->decimal('discount', 15, 2)->default(0)->after('amount');
            }

            if (!Schema::hasColumn('transactions', 'total')) {
                $table->decimal('total', 15, 2)->default(0)->after('discount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            if (Schema::hasColumn('transactions', 'discount')) {
                $table->dropColumn('discount');
            }

            if (Schema::hasColumn('transactions', 'total')) {
                $table->dropColumn('total');
            }
        });
    }
};
