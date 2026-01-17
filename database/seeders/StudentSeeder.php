<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $studentUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->get();

        foreach ($studentUsers as $user) {
            Student::create([
                'student_number' => 'S' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
            ]);
        }
    }
}
