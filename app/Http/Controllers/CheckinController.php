<?php

namespace App\Http\Controllers;

use App\Models\CheckinLog;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index()
    {
        $checkins = CheckinLog::with(['registration.event.club', 'registration.student'])
            ->latest('checkin_time')
            ->paginate(12);

        return view('checkins.index', compact('checkins'));
    }

    public function create()
    {
        $registrations = EventRegistration::with(['event.club', 'student'])
            ->where('status', 'registered')
            ->whereDoesntHave('checkin')
            ->orderByDesc('registered_at')
            ->get();

        return view('checkins.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => ['required', 'exists:event_registrations,id'],
        ]);

        DB::transaction(function () use ($data) {
            $registration = EventRegistration::lockForUpdate()->findOrFail($data['registration_id']);

            if ($registration->status !== 'registered') {
                abort(422, 'Chỉ được check-in cho đăng ký còn hiệu lực.');
            }

            if ($registration->checkin()->exists()) {
                abort(422, 'Sinh viên đã check-in sự kiện này.');
            }

            CheckinLog::create([
                'registration_id' => $registration->id,
                'checkin_time' => now(),
                'status' => 'checked_in',
            ]);
        });

        return redirect()->route('checkins.index')->with('success', 'Check-in thành công.');
    }

    public function show(CheckinLog $checkin)
    {
        $checkin->load(['registration.event.club', 'registration.student']);
        $history = CheckinLog::with('registration.event')
            ->whereHas('registration', fn ($query) => $query->where('student_id', $checkin->registration->student_id))
            ->latest('checkin_time')
            ->get();

        return view('checkins.show', compact('checkin', 'history'));
    }
}
