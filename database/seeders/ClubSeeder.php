<?php
# Vai trò: Mock data cho các câu lạc bộ dùng trong website demo.

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        $clubs = [
            ['name' => 'CLB Tình nguyện', 'short_name' => 'VOL', 'description' => 'Tổ chức hoạt động vì cộng đồng và hỗ trợ sinh viên.', 'email' => 'tinhnguyen@club.test', 'phone' => '024 3564 792', 'location' => 'Nhà K1', 'founding_date' => '2020-10-12', 'advisor' => 'TS. Phạm Văn Phúc', 'president' => 'Phạm Thị Dung', 'max_members' => 100, 'status' => 'active'],
            ['name' => 'CLB Bóng chuyền', 'short_name' => 'VBC', 'description' => 'Kết nối sinh viên yêu thể thao và tổ chức hoạt động bóng chuyền.', 'email' => 'bongchuyen@club.test', 'phone' => '024 3564 791', 'location' => 'Nhà thi đấu TLU', 'founding_date' => '2018-08-20', 'advisor' => 'ThS. Lê Văn Cường', 'president' => 'Bùi Quốc Hùng', 'max_members' => 60, 'status' => 'active'],
            ['name' => 'CLB Kỹ năng mềm', 'short_name' => 'SKILL', 'description' => 'Phát triển kỹ năng mềm, thuyết trình và làm việc nhóm cho sinh viên.', 'email' => 'kynangmem@club.test', 'phone' => '024 3564 789', 'location' => 'A201 - Nhà A2', 'founding_date' => '2016-09-15', 'advisor' => 'TS. Nguyễn Văn An', 'president' => 'Trần Thị Bình', 'max_members' => 80, 'status' => 'active'],
        ];

        foreach ($clubs as $club) {
            Club::updateOrCreate(['name' => $club['name']], $club);
        }
    }
}
