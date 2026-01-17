<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\Seat;
use App\Models\BusSeat;

class BusSeatSeeder extends Seeder
{
    public function run(): void
    {
        $buses = Bus::all();
        $seats = Seat::all();

        foreach ($buses as $bus) {
            // Assign all seats to each bus
            foreach ($seats as $seat) {
                BusSeat::create([
                    'bus_id' => $bus->id,
                    'seat_id' => $seat->id,
                ]);
            }
        }
    }
}
