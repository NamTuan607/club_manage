<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClubRole;

class ClubRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Chủ nhiệm', 'description' => 'Người đứng đầu câu lạc bộ'],
            ['role_name' => 'Phó chủ nhiệm', 'description' => 'Phó lãnh đạo câu lạc bộ'],
            ['role_name' => 'Thành viên', 'description' => 'Thành viên bình thường của câu lạc bộ'],
        ];

        foreach ($roles as $r) {
            ClubRole::firstOrCreate(['role_name' => $r['role_name']], ['description' => $r['description']]);
        }
    }
}
