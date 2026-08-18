<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\ClubRole;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ClubMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['code' => '2051006123', 'club' => 'CLB Kỹ năng mềm', 'role' => 'Chủ nhiệm'],
            ['code' => '2151006456', 'club' => 'CLB Công nghệ thông tin', 'role' => 'Chủ nhiệm'],
            ['code' => '2251006789', 'club' => 'CLB Bóng đá', 'role' => 'Chủ nhiệm'],
            ['code' => '2151006457', 'club' => 'CLB Tình nguyện', 'role' => 'Chủ nhiệm'],
            ['code' => '2051006124', 'club' => 'CLB Kỹ năng mềm', 'role' => 'Thành viên'],
            ['code' => '2151006458', 'club' => 'CLB Công nghệ thông tin', 'role' => 'Trưởng ban Truyền thông'],
        ];

        foreach ($members as $member) {
            $club = Club::where('name', $member['club'])->firstOrFail();
            $student = Student::where('student_code', $member['code'])->firstOrFail();
            $role = ClubRole::where('club_id', $club->id)->where('role_name', $member['role'])->firstOrFail();

            ClubMember::updateOrCreate(
                ['club_id' => $club->id, 'student_id' => $student->id],
                ['club_role_id' => $role->id, 'join_date' => '2024-09-01', 'status' => 'active', 'academic_year' => '2024-2025', 'note' => 'Dữ liệu minh họa để demo.']
            );
        }
    }
}
