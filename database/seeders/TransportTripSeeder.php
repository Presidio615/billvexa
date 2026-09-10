<?php

namespace Database\Seeders;

use App\Models\TransportTrip;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransportTripSeeder extends Seeder
{
    public function run(): void
    {
        TransportTrip::create([
            'operator' => 'God Is Good Motors',
            'from' => 'Awka',
            'to' => 'Lagos',
            'bus_type' => 'Luxury Bus',
            'travel_date' => Carbon::tomorrow(),
            'departure_time' => '07:00:00',
            'price' => 25000,
            'available_seats' => 40,
            'is_active' => true,
        ]);


        TransportTrip::create([
            'operator' => 'Young Shall Grow Motors',
            'from' => 'Awka',
            'to' => 'Abuja',
            'bus_type' => 'Luxury Bus',
            'travel_date' => Carbon::tomorrow(),
            'departure_time' => '06:30:00',
            'price' => 28000,
            'available_seats' => 35,
            'is_active' => true,
        ]);


        TransportTrip::create([
            'operator' => 'Peace Mass Transit',
            'from' => 'Onitsha',
            'to' => 'Lagos',
            'bus_type' => 'Standard Bus',
            'travel_date' => Carbon::tomorrow(),
            'departure_time' => '08:00:00',
            'price' => 22000,
            'available_seats' => 40,
            'is_active' => true,
        ]);


        TransportTrip::create([
            'operator' => 'GUO Transport',
            'from' => 'Awka',
            'to' => 'Port Harcourt',
            'bus_type' => 'Luxury Bus',
            'travel_date' => Carbon::tomorrow(),
            'departure_time' => '07:30:00',
            'price' => 18000,
            'available_seats' => 40,
            'is_active' => true,
        ]);
    }
}