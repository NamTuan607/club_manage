<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRegistrationController extends Controller
{
    public function index()
    {
        $registrations = EventRegistration::with(['event.club', 'student', 'checkin'])
            ->latest('registered_at')
            ->paginate(12);

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $events = Event::with('club')->where('status', 'approved')->orderBy('start_time')->get();
        $students = Student::orderBy('student_code')->get();

        return view('registrations.create', compact('events', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        DB::transaction(function () use ($data) {
            $event = Event::lockForUpdate()->findOrFail($data['event_id']);
            if ($event->status !== 'approved') {
                abort(422, 'Chỉ có thể đăng ký sự kiện đã được duyệt.');
            }

            $registration = EventRegistration::where('event_id', $event->id)
                ->where('student_id', $data['student_id'])
                ->lockForUpdate()
                ->first();

            if ($registration && $registration->status === 'registered') {
                abort(422, 'Sinh viên đã đăng ký sự kiện này.');
            }

            $registeredCount = EventRegistration::where('event_id', $event->id)
                ->where('status', 'registered')
                ->count();

            if ($registeredCount >= $event->capacity) {
                abort(422, 'Sự kiện đã đủ số lượng đăng ký.');
            }

            if ($registration) {
                $registration->update(['status' => 'registered', 'registered_at' => now()]);
            } else {
                EventRegistration::create($data + ['registered_at' => now(), 'status' => 'registered']);
            }
        });

        return redirect()->route('registrations.index')->with('success', 'Đã đăng ký sinh viên vào sự kiện.');
    }

    public function destroy(EventRegistration $registration)
    {
        if ($registration->checkin()->exists()) {
            return back()->with('error', 'Không thể hủy đăng ký đã check-in.');
        }

        $registration->update(['status' => 'cancelled']);

        return redirect()->route('registrations.index')->with('success', 'Đã hủy đăng ký.');
    }
}
