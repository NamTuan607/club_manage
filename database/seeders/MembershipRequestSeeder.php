<?php
# Vai trò: Mock data cho yêu cầu tham gia CLB ở các trạng thái chờ duyệt, duyệt và từ chối.

namespace Database\Seeders;

use App\Models\Club;
use App\Models\MembershipRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembershipRequestSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->value('id');
        $requests = [
            ['CLB Tình nguyện', 100, 'pending'], ['CLB Tình nguyện', 101, 'pending'],
            ['CLB Tình nguyện', 99, 'approved'], ['CLB Tình nguyện', 102, 'rejected'],
            ['CLB Bóng chuyền', 100, 'approved'], ['CLB Bóng chuyền', 3, 'rejected'],
            ['CLB Bóng chuyền', 5, 'pending'], ['CLB Kỹ năng mềm', 2, 'approved'],
            ['CLB Kỹ năng mềm', 4, 'pending'], ['CLB Kỹ năng mềm', 6, 'rejected'],
        ];

        foreach ($requests as [$clubName, $studentId, $status]) {
            $club = Club::where('name', $clubName)->firstOrFail();
            $reviewed = $status === 'pending' ? [] : [
                'reviewed_at' => now()->subDay(),
                'reviewed_by' => $adminId,
                'note' => $status === 'approved' ? 'Đã đáp ứng điều kiện tham gia.' : 'Chưa phù hợp với kế hoạch tuyển thành viên.',
            ];
            MembershipRequest::updateOrCreate(
                ['club_id' => $club->id, 'student_id' => $studentId],
                ['status' => $status, 'requested_at' => now()->subDays(3)] + $reviewed
            );
        }
    }
}
