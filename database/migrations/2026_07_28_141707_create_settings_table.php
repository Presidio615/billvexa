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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
    
            // General
            $table->string('site_name')->default('BillVexa');
            $table->string('logo')->nullable();
            $table->text('contact_information')->nullable();
            $table->string('currency')->default('NGN');
            $table->string('timezone')->default('Africa/Lagos');
    
            // Security
            $table->boolean('two_factor')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->integer('login_attempts')->default(5);
            $table->integer('session_timeout')->default(30);
            $table->integer('lockout_duration')->default(15);
    
            // Transactions
            $table->decimal('minimum_deposit',15,2)->default(100);
            $table->decimal('minimum_withdrawal',15,2)->default(500);
            $table->decimal('charges',8,2)->default(2);
            $table->decimal('profit_percentage',8,2)->default(5);
    
            // APIs
            $table->string('airtime_api')->nullable();
            $table->string('data_api')->nullable();
            $table->string('electricity_api')->nullable();
            $table->string('cable_api')->nullable();
            $table->string('betting_api')->nullable();
    
            // Email
            $table->string('smtp_server')->nullable();
            $table->string('sender_name')->nullable();
    
            // SMS
            $table->string('sms_provider')->nullable();
            $table->text('sms_api_key')->nullable();
    
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
