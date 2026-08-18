<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Cán bộ phụ trách', 'email' => 'canbo@tlu.edu.vn', 'role' => 'admin'],
            ['name' => 'Nguyễn Văn An', 'email' => 'an@tlu.edu.vn', 'role' => 'student'],
            ['name' => 'Trần Thị Bình', 'email' => 'binh@tlu.edu.vn', 'role' => 'student'],
            ['name' => 'Lê Văn Cường', 'email' => 'cuong@tlu.edu.vn', 'role' => 'student'],
            ['name' => 'Phạm Thị Dung', 'email' => 'dung@tlu.edu.vn', 'role' => 'student'],
            ['name' => 'Hoàng Minh Đức', 'email' => 'duc@tlu.edu.vn', 'role' => 'student'],
            ['name' => 'Đỗ Thu Hà', 'email' => 'ha@tlu.edu.vn', 'role' => 'student'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user + ['password' => Hash::make('password')]
            );
        }
    }
}
