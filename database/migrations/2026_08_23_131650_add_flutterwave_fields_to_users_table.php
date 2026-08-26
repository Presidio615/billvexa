<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('flutterwave_customer_id')->nullable()->after('id');
            $table->string('flutterwave_account_reference')->nullable()->unique()->after('flutterwave_customer_id');
            $table->string('flutterwave_account_id')->nullable()->after('flutterwave_account_reference');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'flutterwave_customer_id',
                'flutterwave_account_reference',
                'flutterwave_account_id',
            ]);
        });
    }
};