<?php
# Vai trò: Duyệt hoặc từ chối yêu cầu tham gia CLB, đồng thời kiểm tra sức chứa ở backend.

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\MembershipRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MembershipRequestController extends Controller
{
    public function index()
    {
        $requests = MembershipRequest::with([
            'student',
            'club' => fn ($query) => $query->withCount(['members as active_members_count' => fn ($members) => $members->where('status', 'active')]),
            'reviewer',
        ])->latest('requested_at')->paginate(15);
        return view('membership_requests.index', compact('requests'));
    }

    public function approve(MembershipRequest $membershipRequest)
    {
        DB::transaction(function () use ($membershipRequest) {
            $request = MembershipRequest::lockForUpdate()->findOrFail($membershipRequest->id);
            if ($request->status !== 'pending') {
                throw ValidationException::withMessages(['request' => 'Yêu cầu này đã được xử lý.']);
            }
            $club = Club::lockForUpdate()->findOrFail($request->club_id);
            $currentMembers = ClubMember::where('club_id', $club->id)->where('status', 'active')->count();
            if ($currentMembers >= $club->max_members) {
                throw ValidationException::withMessages(['capacity' => 'CLB đã đủ số lượng thành viên.']);
            }
            if (ClubMember::where('club_id', $club->id)->where('student_id', $request->student_id)->exists()) {
                throw ValidationException::withMessages(['student' => 'Sinh viên đã là thành viên của CLB.']);
            }
            $role = $club->roles()->where('role_name', 'Thành viên')->first() ?? $club->roles()->firstOrFail();
            ClubMember::create([
                'club_id' => $club->id, 'student_id' => $request->student_id, 'club_role_id' => $role->id,
                'join_date' => today(), 'status' => 'active',
                'academic_year' => now()->format('Y') . '-' . now()->addYear()->format('Y'),
                'note' => 'Tạo từ yêu cầu tham gia được duyệt.',
            ]);
            $request->update($this->reviewData('approved'));
        });
        return redirect()->route('membership-requests.index')->with('success', 'Đã duyệt yêu cầu và thêm sinh viên vào CLB.');
    }

    public function reject(MembershipRequest $membershipRequest)
    {
        if ($membershipRequest->status !== 'pending') {
            return back()->with('error', 'Yêu cầu này đã được xử lý.');
        }
        $membershipRequest->update($this->reviewData('rejected'));
        return redirect()->route('membership-requests.index')->with('success', 'Đã từ chối yêu cầu tham gia CLB.');
    }

    private function reviewData(string $status): array
    {
        return ['status' => $status, 'reviewed_at' => now(), 'reviewed_by' => User::where('role', 'admin')->value('id')];
    }
}
