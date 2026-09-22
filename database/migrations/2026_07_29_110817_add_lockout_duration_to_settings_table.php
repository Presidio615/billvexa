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
        if (!Schema::hasColumn('settings', 'lockout_duration')) { 
            Schema::table('settings', function (Blueprint $table) { 
            $table->integer('lockout_duration')
            ->default(15) 
            ->after('login_attempts'); 
        }); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
    
            $table->dropColumn('lockout_duration');
    
        });
    }
};
