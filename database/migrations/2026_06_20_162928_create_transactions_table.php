<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('type');

            $table->string('network')->nullable();

            $table->string('phone')->nullable();

            $table->string('service');

            $table->decimal('amount', 12, 2);

            $table->decimal('discount',15,2)->default(0);
            
            $table->decimal('total',15,2)->default(0);

            $table->string('reference')->unique();

            $table->decimal('profit', 12, 2)->default(0);

            $table->enum('status', [
                'pending',
                'successful',
                'failed',
                'refunded',
                'reversed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};