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
            'Chủ nhiệm' => 'Phụ trách chung các hoạt động của CLB.',
            'Phó chủ nhiệm' => 'Hỗ trợ điều hành và tổ chức hoạt động.',
            'Trưởng ban Truyền thông' => 'Phụ trách truyền thông, nội dung và hình ảnh.',
            'Thành viên' => 'Tham gia hoạt động của câu lạc bộ.',
        ];

        Club::all()->each(function (Club $club) use ($roles) {
            foreach ($roles as $roleName => $description) {
                ClubRole::updateOrCreate(
                    ['club_id' => $club->id, 'role_name' => $roleName],
                    ['description' => $description]
                );
            }
        });
    }
}
