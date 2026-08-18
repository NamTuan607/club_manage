<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [['name' => 'Quản trị viên demo', 'email' => 'admin@club.test', 'role' => 'admin']];

        foreach (StudentsSeeder::students() as $student) {
            $users[] = [
                'name' => $student['full_name'],
                'email' => $student['email'],
                'role' => 'student',
            ];
        }

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user + ['password' => Hash::make('password')]
            );
        }
    }
}
