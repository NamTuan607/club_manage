<?php
# Vai trò: Mock data thành viên CLB, gồm 99/100 thành viên để demo giới hạn sức chứa.

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
        $club = Club::where('name', 'CLB Tình nguyện')->firstOrFail();
        $role = ClubRole::where('club_id', $club->id)->where('role_name', 'Thành viên')->firstOrFail();

        // Cố ý tạo 99/100 thành viên cho màn hình duyệt yêu cầu tham gia.
        Student::orderBy('id')->take(99)->get()->each(function (Student $student) use ($club, $role) {
            ClubMember::updateOrCreate(
                ['club_id' => $club->id, 'student_id' => $student->id],
                ['club_role_id' => $role->id, 'join_date' => '2025-09-01', 'status' => 'active', 'academic_year' => '2025-2026', 'note' => 'Dữ liệu demo.']
            );
        });

        foreach ([['CLB Bóng chuyền', 100], ['CLB Kỹ năng mềm', 2]] as [$clubName, $studentId]) {
            $otherClub = Club::where('name', $clubName)->firstOrFail();
            $otherRole = ClubRole::where('club_id', $otherClub->id)->where('role_name', 'Thành viên')->firstOrFail();
            ClubMember::updateOrCreate(
                ['club_id' => $otherClub->id, 'student_id' => $studentId],
                ['club_role_id' => $otherRole->id, 'join_date' => '2025-09-01', 'status' => 'active', 'academic_year' => '2025-2026', 'note' => 'Dữ liệu demo.']
            );
        }
    }
}
