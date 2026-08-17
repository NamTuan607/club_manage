<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Nguyễn Văn A', 'email' => 'nvana@example.test'],
            ['name' => 'Trần Thị B', 'email' => 'ttb@example.test'],
            ['name' => 'Lê Văn C', 'email' => 'lvc@example.test'],
            ['name' => 'Phạm Thị D', 'email' => 'ptd@example.test'],
            ['name' => 'Hoàng Văn E', 'email' => 'hve@example.test'],
            ['name' => 'Đỗ Thị F', 'email' => 'dtf@example.test'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password'),
                    'role' => 'student'
                ]
            );
        }

        $this->command->info('UsersSeeder: seeded/updated '.count($users).' users.');
    }
}
