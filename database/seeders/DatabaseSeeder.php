<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      RegionSeeder::class,      // 1. Regions (Independent)
      LaratrustSeeder::class,   // 2. Roles, Permissions, Base Users (Truncates Users!)
      // RoleSeeder::class,     // REMOVED: Redundant, handled by LaratrustSeeder
      UsersSeeder::class,       // 3. Update Base Users + Create Extra Users
      DriverSeeder::class,
      ManagerSeeder::class,
      StudentSeeder::class,
      BusSeeder::class,
      SeatSeeder::class,
      BusSeatSeeder::class,
      RouteSeeder::class,
      TripSeeder::class,
      BookingSeeder::class,
    ]);
  }
}
