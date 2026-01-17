<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        // Create 40 standard bus seats
        for ($i = 1; $i <= 40; $i++) {
            Seat::create([
                'seat_number' => $i,
            ]);
        }
    }
}
