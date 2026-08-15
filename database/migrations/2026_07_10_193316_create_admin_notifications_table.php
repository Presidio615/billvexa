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
        Schema::create('admin_notifications', function (Blueprint $table) {

        $table->id();
    
        $table->foreignId('admin_id')
              ->nullable()
              ->constrained('admins')
              ->nullOnDelete();
    
        $table->string('title');
    
        $table->text('message');
    
        $table->string('link')->nullable();
    
        $table->boolean('is_read')->default(false);

        $table->enum('recipient_type', [
            'everyone',
            'user',
            'role'
        ]);
        $table->string('recipient')->nullable();

        $table->boolean('push')->default(true);

        $table->boolean('email')->default(false);

        $table->boolean('sms')->default(false);

        $table->enum('status', [
            'Pending',
            'Sent',
            'Failed'
        ])->default('Pending');

        $table->unsignedBigInteger('created_by');

    
        $table->timestamps();
    
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
