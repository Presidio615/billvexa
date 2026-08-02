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
        Schema::table('settings', function (Blueprint $table) {
            //

            $table->decimal('airtime_discount', 5, 2)->default(3.00);
            $table->decimal('data_discount', 5, 2)->default(2.00);
            $table->decimal('electricity_discount', 5, 2)->default(1.00);
            $table->decimal('cable_discount', 5, 2)->default(1.50);
            $table->decimal('betting_discount', 5, 2)->default(0.50);
            $table->decimal('education_discount', 5, 2)->default(2.00);
            $table->decimal('exam_discount', 5, 2)->default(2.00);

       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn([
                'airtime_discount',
                'data_discount',
                'electricity_discount',
                'cable_discount',
                'betting_discount',
                'education_discount',
                'exam_discount',
            ]);

            $table->decimal('charges', 8, 2)->default(2);
      
        });
    }
};
