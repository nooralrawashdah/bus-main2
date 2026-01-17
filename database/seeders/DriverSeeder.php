<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\User;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $driverUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'driver');
        })->get();

        foreach ($driverUsers as $user) {
            Driver::create([
                'driver_license_number' => 'D' . rand(10000, 99999),
                'user_id' => $user->id,
            ]);
        }
    }
}
