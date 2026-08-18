<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        $clubs = [
            ['name' => 'CLB Kỹ năng mềm', 'short_name' => 'SKILL', 'description' => 'Phát triển kỹ năng mềm, thuyết trình và làm việc nhóm cho sinh viên.', 'email' => 'kynangmem@tlu.edu.vn', 'phone' => '024 3564 789', 'location' => 'A201 - Nhà A2', 'founding_date' => '2016-09-15', 'advisor' => 'TS. Nguyễn Văn A', 'president' => 'Nguyễn Văn An', 'max_members' => 150, 'status' => 'active'],
            ['name' => 'CLB Công nghệ thông tin', 'short_name' => 'ITC', 'description' => 'Câu lạc bộ dành cho sinh viên yêu thích công nghệ và lập trình.', 'email' => 'itclub@tlu.edu.vn', 'phone' => '024 3564 790', 'location' => 'A2-305', 'founding_date' => '2019-09-15', 'advisor' => 'TS. Trần Văn B', 'president' => 'Trần Thị Bình', 'max_members' => 200, 'status' => 'active'],
            ['name' => 'CLB Bóng đá', 'short_name' => 'TFC', 'description' => 'Kết nối sinh viên yêu thể thao và tổ chức giải bóng đá.', 'email' => 'bongda@tlu.edu.vn', 'phone' => '024 3564 791', 'location' => 'Sân vận động TLU', 'founding_date' => '2018-08-20', 'advisor' => 'ThS. Lê Văn D', 'president' => 'Lê Văn Cường', 'max_members' => 120, 'status' => 'active'],
            ['name' => 'CLB Tình nguyện', 'short_name' => 'VOL', 'description' => 'Tổ chức hoạt động vì cộng đồng và hỗ trợ sinh viên.', 'email' => 'tinhnguyen@tlu.edu.vn', 'phone' => '024 3564 792', 'location' => 'Nhà K1', 'founding_date' => '2020-10-12', 'advisor' => 'TS. Phạm Văn F', 'president' => 'Phạm Thị Dung', 'max_members' => 100, 'status' => 'active'],
        ];

        foreach ($clubs as $club) {
            Club::updateOrCreate(['name' => $club['name']], $club);
        }
    }
}
