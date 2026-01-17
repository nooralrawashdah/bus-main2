<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Trip;
use App\Models\BusSeat;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Get students from users table (those with student role)
        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->get();

        // Get all trips
        $trips = Trip::all();

        // Get all bus seats
        $busSeats = BusSeat::all();

        $i = 0;
        foreach ($students as $student) {
            if ($trips->count() === 0 || $busSeats->count() === 0) {
                continue;
            }

            // Distribute bookings across trips and seats
            $trip = $trips[$i % $trips->count()];
            $busSeat = $busSeats->where('bus_id', $trip->bus_id)->skip($i)->first();

            if ($busSeat) {
                Booking::create([
                    'user_id' => $student->id,
                    'trip_id' => $trip->id,
                    'bus_seat_id' => $busSeat->id,
                ]);
            }

            $i++;
        }
    }
}
