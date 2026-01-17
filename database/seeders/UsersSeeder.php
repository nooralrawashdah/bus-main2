<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Region;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Define users with their specific data and roles
        $users = [
            // Base Admin (might be created by Laratrust, so we update or create)
            [
                'email' => 'admin@app.com',
                'name' => 'Admin',
                'Phone_number' => '0791111111',
                'password' => 'password',
                'region_name' => 'Amman', // Mapping to Region Name is safer
                'role' => 'admin'
            ],
            // Base Driver
            [
                'email' => 'driver@app.com',
                'name' => 'Driver',
                'Phone_number' => '0792222222',
                'password' => 'password',
                'region_name' => 'Irbid',
                'role' => 'driver'
            ],
            // Base Student
            [
                'email' => 'student@app.com',
                'name' => 'Student User',
                'Phone_number' => '0793333333',
                'password' => 'password',
                'region_name' => 'Zarqa',
                'role' => 'student'
            ],
            // Extra Students
            [
                'email' => 'ali@student.com',
                'name' => 'ali ali',
                'Phone_number' => '0793333333',
                'password' => 'password',
                'region_name' => 'Madaba',
                'role' => 'student'
            ],
            [
                'email' => 'hashem@student.com',
                'name' => 'hashem',
                'Phone_number' => '0793333333',
                'password' => 'password',
                'region_name' => 'Balqa',
                'role' => 'student'
            ],
            // Extra Drivers
            [
                'email' => 'mohammad.driver@app.com',
                'name' => 'Mohammad Driver',
                'Phone_number' => '0794444444',
                'password' => 'password',
                'region_name' => 'Balqa',
                'role' => 'driver'
            ],
            [
                'email' => 'khaled.driver@app.com',
                'name' => 'Khaled Driver',
                'Phone_number' => '0795555555',
                'password' => 'password',
                'region_name' => 'Madaba',
                'role' => 'driver'
            ],
            [
                'email' => 'omar.driver@app.com',
                'name' => 'Omar Driver',
                'Phone_number' => '0796666666',
                'password' => 'password',
                'region_name' => 'Amman',
                'role' => 'driver'
            ],
        ];

        foreach ($users as $userData) {
            // Find region by name to get correct ID
            $region = Region::where('region_name', $userData['region_name'])->first();
            $regionId = $region ? $region->id : null;

            // Check if user exists (e.g. created by Laratrust)
            $user = User::where('email', $userData['email'])->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'name' => $userData['name'],
                    'Phone_number' => $userData['Phone_number'],
                    'region_id' => $regionId,
                    // Don't overwrite password if it exists, or do? Laratrust sets it to bcrypt('password')
                    // We can ensure it's set to our standard
                    'password' => Hash::make($userData['password']),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'Phone_number' => $userData['Phone_number'],
                    'password' => Hash::make($userData['password']),
                    'region_id' => $regionId,
                ]);
            }

            // Sync Role (Safely)
            if (!$user->hasRole($userData['role'])) {
                $user->addRole($userData['role']);
            }
        }
    }
}
