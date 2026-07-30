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
        Schema::create('services', function (Blueprint $table) {
    
            $table->id();
    
            $table->string('name');
    
            $table->string('provider');
    
            $table->decimal('charge',10,2)->default(0);
    
            $table->decimal('profit',8,2)->default(0);
    
            $table->decimal('minimum',10,2)->default(0);
    
            $table->decimal('maximum',10,2)->default(0);
    
            $table->string('api_name')->nullable();
    
            $table->boolean('status')->default(true);
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
