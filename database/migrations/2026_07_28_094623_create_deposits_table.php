<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount',15,2);

            $table->string('method')->default('Bank Transfer');

            $table->string('reference')->unique();

            $table->string('receipt')->nullable();

            $table->enum('status',[
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->text('remark')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};