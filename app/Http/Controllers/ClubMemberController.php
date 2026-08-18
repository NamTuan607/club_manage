<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\ClubRole;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClubMemberController extends Controller
{
    public function index()
    {
        $members = ClubMember::with(['club', 'student', 'clubRole'])->latest('join_date')->paginate(12);

        return view('club_members.index', compact('members'));
    }

    public function create()
    {
        return view('club_members.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            $club = Club::lockForUpdate()->findOrFail($data['club_id']);
            if ($data['status'] === 'active' && $club->members()->where('status', 'active')->count() >= $club->max_members) {
                throw ValidationException::withMessages(['club_id' => 'CLB đã đạt số lượng thành viên tối đa.']);
            }

            ClubMember::create($data);
        });

        return redirect()->route('club_members.index')->with('success', 'Đã thêm thành viên vào CLB.');
    }

    public function show(ClubMember $clubMember)
    {
        $clubMember->load(['club', 'student', 'clubRole']);

        return view('club_members.show', compact('clubMember'));
    }

    public function edit(ClubMember $clubMember)
    {
        return view('club_members.edit', ['clubMember' => $clubMember] + $this->formData());
    }

    public function update(Request $request, ClubMember $clubMember)
    {
        $clubMember->update($this->validated($request, $clubMember));

        return redirect()->route('club_members.show', $clubMember)->with('success', 'Đã cập nhật thành viên CLB.');
    }

    public function destroy(ClubMember $clubMember)
    {
        $clubMember->delete();

        return redirect()->route('club_members.index')->with('success', 'Đã xóa thành viên khỏi CLB.');
    }

    private function formData(): array
    {
        return [
            'clubs' => Club::where('status', 'active')->orderBy('name')->get(),
            'students' => Student::orderBy('student_code')->get(),
            'roles' => ClubRole::with('club')->orderBy('club_id')->orderBy('role_name')->get(),
        ];
    }

    private function validated(Request $request, ?ClubMember $current = null): array
    {
        $data = $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'student_id' => ['required', 'exists:students,id'],
            'club_role_id' => ['required', 'exists:club_roles,id'],
            'join_date' => ['required', 'date'],
            'leave_date' => ['nullable', 'date', 'after_or_equal:join_date'],
            'status' => ['required', 'in:active,inactive,pending'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $role = ClubRole::findOrFail($data['club_role_id']);
        if ((int) $role->club_id !== (int) $data['club_id']) {
            throw ValidationException::withMessages(['club_role_id' => 'Chức vụ phải thuộc câu lạc bộ đã chọn.']);
        }

        $duplicate = ClubMember::where('club_id', $data['club_id'])
            ->where('student_id', $data['student_id'])
            ->when($current, fn ($query) => $query->whereKeyNot($current->id))
            ->exists();
        if ($duplicate) {
            throw ValidationException::withMessages(['student_id' => 'Sinh viên đã là thành viên của CLB này.']);
        }

        $club = Club::findOrFail($data['club_id']);
        $activeCount = $club->members()->where('status', 'active')
            ->when($current, fn ($query) => $query->whereKeyNot($current->id))
            ->count();
        if ($data['status'] === 'active' && $activeCount >= $club->max_members) {
            throw ValidationException::withMessages(['club_id' => 'CLB đã đạt số lượng thành viên tối đa.']);
        }

        return $data;
    }
}
