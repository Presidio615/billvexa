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
        $columns = [
            'airtime_discount',
            'data_discount',
            'electricity_discount',
            'cable_discount',
            'betting_discount',
            'education_discount',
            'transport_discount',
            'sport_discount',
            'flight_discount',
            'hotel_discount',
            'gift_card_discount',
            'ticket_discount',
        ];

        foreach ($columns as $column) {
            if (!Schema::hasColumn('settings', $column)) {
                Schema::table('settings', function (Blueprint $table) use ($column) {
                    $table->decimal($column, 5, 2)
                        ->default(3);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'airtime_discount',
            'data_discount',
            'electricity_discount',
            'cable_discount',
            'betting_discount',
            'education_discount',
            'transport_discount',
            'sport_discount',
            'flight_discount',
            'hotel_discount',
            'gift_card_discount',
            'ticket_discount',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('settings', $column)) {
                Schema::table('settings', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};