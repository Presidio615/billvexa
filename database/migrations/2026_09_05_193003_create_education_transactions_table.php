<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('request_id')->unique();

            $table->string('service_id');

            $table->string('variation_code')->nullable();

            $table->string('service_name')->nullable();

            $table->string('billers_code')->nullable();

            $table->string('phone')->nullable();

            $table->decimal('amount', 15, 2);

            $table->string('status')->default('pending');

            $table->string('vtpass_transaction_id')->nullable();

            $table->text('purchased_code')->nullable();

            $table->json('response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_transactions');
    }
};