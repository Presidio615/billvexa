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
        Schema::table('users', function (Blueprint $table) {
            $table->string('paystack_customer_code')->nullable()->unique();
            $table->string('paystack_dva_id')->nullable()->unique();
            $table->string('paystack_account_number')->nullable()->unique();
            $table->string('paystack_account_name')->nullable();
            $table->string('paystack_bank_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'paystack_customer_code',
                'paystack_dva_id',
                'paystack_account_number',
                'paystack_account_name',
                'paystack_bank_name',
            ]);
        });
    }
};
