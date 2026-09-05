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
        Schema::create('electricity_transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('request_id')
                ->unique();

            $table->string('provider');

            $table->string('service_id');

            $table->string('meter_number');

            $table->string('meter_type');

            $table->string('customer_name')
                ->nullable();

            $table->text('customer_address')
                ->nullable();

            $table->decimal('amount', 15, 2);

            $table->decimal('discount', 15, 2)
                ->default(0);

            $table->decimal('total', 15, 2);

            $table->string('phone');

            $table->string('token')
                ->nullable();

            $table->string('units')
                ->nullable();

            $table->string('vtpass_transaction_id')
                ->nullable();

            $table->string('status')
                ->default('pending');

            $table->text('response_message')
                ->nullable();

            $table->json('api_response')
                ->nullable();

            $table->timestamp('purchased_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'user_id',
                'status'
            ]);

            $table->index('meter_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_transactions');
    }
};
