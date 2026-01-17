<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manager;
use App\Models\User;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $managerUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'manager');
        })->get();

        foreach ($managerUsers as $user) {
            Manager::create([
                'experience_years' => rand(1, 10) . ' years',
                'user_id' => $user->id,
            ]);
        }
    }
}
