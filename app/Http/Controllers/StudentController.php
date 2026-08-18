<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withCount(['clubMembers', 'registrations', 'points'])->orderBy('student_code')->paginate(12);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        DB::transaction(function () use ($data) {
            $user = User::create(['name' => $data['full_name'], 'email' => $data['email'], 'password' => Hash::make('password'), 'role' => 'student']);
            Student::create($this->studentData($data) + ['user_id' => $user->id]);
        });
        return redirect()->route('students.index')->with('success', 'Đã thêm sinh viên.');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'clubMembers.club', 'clubMembers.clubRole', 'registrations.event', 'points.event', 'points.rule']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $this->validated($request, $student);
        DB::transaction(function () use ($data, $student) {
            $student->user->update(['name' => $data['full_name'], 'email' => $data['email']]);
            $student->update($this->studentData($data));
        });
        return redirect()->route('students.show', $student)->with('success', 'Đã cập nhật sinh viên.');
    }

    public function destroy(Student $student)
    {
        if ($student->clubMembers()->exists() || $student->registrations()->exists() || $student->points()->exists()) {
            return back()->with('error', 'Không thể xóa sinh viên đã có dữ liệu CLB, đăng ký hoặc điểm.');
        }
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            $user?->delete();
        });
        return redirect()->route('students.index')->with('success', 'Đã xóa sinh viên.');
    }

    private function validated(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'student_code' => ['required', 'string', 'max:20', Rule::unique('students', 'student_code')->ignore($student?->id)],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student?->user_id)],
            'class' => ['required', 'string', 'max:30'],
            'faculty' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);
    }

    private function studentData(array $data): array
    {
        return collect($data)->only(['student_code', 'full_name', 'class', 'faculty', 'phone'])->all();
    }
}
