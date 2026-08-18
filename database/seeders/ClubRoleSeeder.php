<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubRole;
use Illuminate\Database\Seeder;

class ClubRoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['CLB Tình nguyện', 'Chủ nhiệm', 'Phụ trách chung các hoạt động của CLB.'],
            ['CLB Tình nguyện', 'Thành viên', 'Tham gia hoạt động của câu lạc bộ.'],
            ['CLB Bóng chuyền', 'Thành viên', 'Tham gia luyện tập và thi đấu bóng chuyền.'],
            ['CLB Kỹ năng mềm', 'Chủ nhiệm', 'Điều hành các hoạt động phát triển kỹ năng.'],
            ['CLB Kỹ năng mềm', 'Thành viên', 'Tham gia workshop và hoạt động kỹ năng.'],
        ];

        foreach ($roles as [$clubName, $roleName, $description]) {
            $club = Club::where('name', $clubName)->firstOrFail();
            ClubRole::updateOrCreate(
                ['club_id' => $club->id, 'role_name' => $roleName],
                ['description' => $description]
            );
        }
    }
}
