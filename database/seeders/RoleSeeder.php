<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        Role::create(['name' => 'admin', 'display_name' => 'System Administrator', 'description' => 'Full access to manage the system']); 
        Role::create(['name' => 'driver', 'display_name' => 'Bus Driver', 'description' => 'Access to bus and trip management']); 
        Role::create(['name' => 'student', 'display_name' => 'Student', 'description' => 'Access to booking and trip information']);
    }
}
