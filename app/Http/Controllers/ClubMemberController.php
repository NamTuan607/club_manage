<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClubMember;
use App\Models\Club;
use App\Models\Student;
use App\Models\ClubRole;
use Carbon\Carbon;

class ClubMemberController extends Controller
{
    public function index()
    {
        $members = ClubMember::with([
            'club',
            'student',
            'clubRole'
        ])->get();

        return view('club_members.index', compact('members'));
    }

    public function create()
    {
        $clubs = Club::all();
        $students = Student::all();
        $roles = ClubRole::all();

        return view('club_members.create', compact('clubs','students','roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'student_id' => 'required|exists:students,id',
            'club_role_id' => 'required|exists:club_roles,id',
            'join_date' => 'required|date',
            'leave_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,pending',
            'academic_year' => 'nullable|string|max:50',
            'note' => 'nullable|string'
        ]);

        // Prevent duplicate membership for same student and club
        $exists = ClubMember::where('club_id', $data['club_id'])
            ->where('student_id', $data['student_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['student_id' => 'Sinh viên này đã là thành viên của CLB.'])->withInput();
        }

        // Check leave_date >= join_date
        if (!empty($data['leave_date']) && !empty($data['join_date'])) {
            if (Carbon::parse($data['leave_date'])->lt(Carbon::parse($data['join_date']))) {
                return redirect()->back()->withErrors(['leave_date' => 'Ngày rời không được nhỏ hơn ngày tham gia.'])->withInput();
            }
        }

        ClubMember::create($data);

        return redirect()->route('club_members.index')->with('success','Đã thêm thành viên.');
    }

    public function show(string $id)
    {
        $member = ClubMember::with(['club','student','clubRole'])->findOrFail($id);

        return view('club_members.show', compact('member'));
    }

    public function edit(string $id)
    {
        $member = ClubMember::findOrFail($id);
        $clubs = Club::all();
        $students = Student::all();
        $roles = ClubRole::all();

        return view('club_members.edit', compact('member','clubs','students','roles'));
    }

    public function update(Request $request, string $id)
    {
        $member = ClubMember::findOrFail($id);

        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'student_id' => 'required|exists:students,id',
            'club_role_id' => 'required|exists:club_roles,id',
            'join_date' => 'required|date',
            'leave_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,pending',
            'academic_year' => 'nullable|string|max:50',
            'note' => 'nullable|string'
        ]);

        // Prevent duplicate membership for same student and club (exclude current)
        $exists = ClubMember::where('club_id', $data['club_id'])
            ->where('student_id', $data['student_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['student_id' => 'Sinh viên này đã là thành viên của CLB.'])->withInput();
        }

        // Check leave_date >= join_date
        if (!empty($data['leave_date']) && !empty($data['join_date'])) {
            if (Carbon::parse($data['leave_date'])->lt(Carbon::parse($data['join_date']))) {
                return redirect()->back()->withErrors(['leave_date' => 'Ngày rời không được nhỏ hơn ngày tham gia.'])->withInput();
            }
        }

        $member->update($data);

        return redirect()->route('club_members.index')->with('success','Đã cập nhật thành viên.');
    }

    public function destroy(string $id)
    {
        $member = ClubMember::findOrFail($id);

        $member->delete();

        return redirect()->route('club_members.index');
    }
}