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
        Schema::create('data_bundle_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('request_id')->unique();

            $table->string('network');
            $table->string('service_id');

            $table->string('variation_code');
            $table->string('variation_name')->nullable();

            $table->string('phone');

            $table->decimal('amount', 15, 2);

            $table->string('vtpass_transaction_id')->nullable();

            $table->string('status')->default('pending');

            $table->text('response_message')->nullable();

            $table->json('api_response')->nullable();

            $table->timestamp('purchased_at')->nullable();

            $table->timestamps();

            $table->index([
                'user_id',
                'status'
            ]);

            $table->index('phone');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bundle_transactions');
    }
};
