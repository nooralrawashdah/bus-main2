<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\Driver;

class BusSeeder extends Seeder
{
   public function run(): void
   {
      $drivers = Driver::all();

      $plateNumbers = [
         '20-12345',
         '20-67890',
         '20-54321',
         '20-98765',
      ];

      $i = 0;
      foreach ($drivers as $driver) {
         Bus::create([
            'plate_number' => $plateNumbers[$i] ?? '20-' . rand(10000, 99999),
            'capacity' => rand(30, 50),
            'driver_id' => $driver->id,
         ]);
         $i++;
      }
   }
}
