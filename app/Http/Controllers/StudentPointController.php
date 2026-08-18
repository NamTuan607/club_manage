<?php

namespace App\Http\Controllers;

use App\Models\ActivityPointRule;
use App\Models\EventRegistration;
use App\Models\StudentPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentPointController extends Controller
{
    public function index()
    {
        $studentPoints = StudentPoint::with(['student', 'event.club', 'rule.category', 'certificate'])
            ->latest('awarded_at')
            ->paginate(12);

        $studentTotals = StudentPoint::query()
            ->selectRaw('student_id, SUM(points) as total_points')
            ->with('student')
            ->groupBy('student_id')
            ->orderByDesc('total_points')
            ->take(5)
            ->get();

        return view('student_points.index', compact('studentPoints', 'studentTotals'));
    }

    public function create()
    {
        $registrations = EventRegistration::with(['event.club', 'student'])
            ->where('status', 'registered')
            ->whereHas('checkin')
            ->orderByDesc('registered_at')
            ->get();
        $rules = ActivityPointRule::with('category')->orderBy('event_category_id')->get();

        return view('student_points.create', compact('registrations', 'rules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => ['required', 'exists:event_registrations,id'],
            'rule_id' => ['required', 'exists:activity_point_rules,id'],
        ]);

        DB::transaction(function () use ($data) {
            $registration = EventRegistration::with(['event', 'checkin'])->lockForUpdate()->findOrFail($data['registration_id']);
            $rule = ActivityPointRule::findOrFail($data['rule_id']);

            if (!$registration->checkin || $registration->status !== 'registered') {
                throw ValidationException::withMessages([
                    'registration_id' => 'Chỉ được cộng điểm sau khi sinh viên đã check-in.',
                ]);
            }

            if ($registration->event->category_id !== $rule->event_category_id) {
                throw ValidationException::withMessages([
                    'rule_id' => 'Quy tắc điểm phải thuộc đúng loại của sự kiện.',
                ]);
            }

            $exists = StudentPoint::where('student_id', $registration->student_id)
                ->where('event_id', $registration->event_id)
                ->where('rule_id', $rule->id)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'registration_id' => 'Sinh viên đã được cộng điểm theo quy tắc này cho sự kiện.',
                ]);
            }

            StudentPoint::create([
                'student_id' => $registration->student_id,
                'event_id' => $registration->event_id,
                'rule_id' => $rule->id,
                'points' => $rule->points,
                'awarded_at' => now(),
            ]);
        });

        return redirect()->route('student-points.index')->with('success', 'Đã cộng điểm hoạt động cho sinh viên.');
    }

    public function show(StudentPoint $studentPoint)
    {
        $studentPoint->load(['student', 'event.club', 'event.category', 'rule.category', 'certificate']);
        $totalPoints = StudentPoint::where('student_id', $studentPoint->student_id)->sum('points');

        return view('student_points.show', compact('studentPoint', 'totalPoints'));
    }

    public function destroy(StudentPoint $studentPoint)
    {
        if ($studentPoint->certificate()->exists()) {
            return back()->with('error', 'Không thể xóa điểm đã được dùng để cấp chứng nhận.');
        }

        $studentPoint->delete();

        return redirect()->route('student-points.index')->with('success', 'Đã xóa bản ghi điểm hoạt động.');
    }
}
