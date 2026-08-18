<?php

namespace App\Http\Controllers;

use App\Models\ActivityPointRule;
use App\Models\CheckinLog;
use App\Models\EventRegistration;
use App\Models\StudentPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index()
    {
        $checkins = CheckinLog::with(['registration.event.club', 'registration.student', 'registration.event.category'])
            ->latest('checkin_time')->paginate(12);
        return view('checkins.index', compact('checkins'));
    }

    public function create()
    {
        $registrations = EventRegistration::with(['event.club', 'student'])
            ->where('status', 'registered')->whereDoesntHave('checkin')
            ->orderByDesc('registered_at')->get();
        return view('checkins.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['registration_id' => ['required', 'exists:event_registrations,id']]);
        DB::transaction(function () use ($data) {
            $registration = EventRegistration::lockForUpdate()->findOrFail($data['registration_id']);
            if ($registration->status !== 'registered') {
                abort(422, 'Chỉ được check-in cho đăng ký còn hiệu lực.');
            }
            if ($registration->checkin()->exists()) {
                abort(422, 'Sinh viên đã check-in sự kiện này.');
            }
            CheckinLog::create(['registration_id' => $registration->id, 'checkin_time' => now(), 'status' => 'pending']);
        });
        return redirect()->route('checkins.index')->with('success', 'Đã tạo check-in, chờ cán bộ duyệt.');
    }

    public function show(CheckinLog $checkin)
    {
        $checkin->load(['registration.event.club', 'registration.event.category', 'registration.student']);
        $history = CheckinLog::with('registration.event')
            ->whereHas('registration', fn ($query) => $query->where('student_id', $checkin->registration->student_id))
            ->latest('checkin_time')->get();
        return view('checkins.show', compact('checkin', 'history'));
    }

    public function approve(CheckinLog $checkin)
    {
        $createdPoint = false;
        DB::transaction(function () use ($checkin, &$createdPoint) {
            $checkin = CheckinLog::with('registration.event')->lockForUpdate()->findOrFail($checkin->id);
            if ($checkin->status !== 'pending') {
                abort(422, 'Check-in này đã được duyệt, không thể cộng điểm lần nữa.');
            }
            $registration = $checkin->registration;
            $event = $registration->event;
            $rule = ActivityPointRule::where('event_category_id', $event->category_id)->where('event_name', $event->title)->first()
                ?? ActivityPointRule::where('event_category_id', $event->category_id)->whereNull('event_name')->orderBy('id')->first();
            if (!$rule) {
                abort(422, 'Chưa có quy tắc điểm phù hợp cho sự kiện này.');
            }
            $point = StudentPoint::firstOrCreate(
                ['student_id' => $registration->student_id, 'event_id' => $event->id],
                ['points' => $rule->points, 'awarded_at' => now()]
                    + ['rule_id' => $rule->id]
            );
            $createdPoint = $point->wasRecentlyCreated;
            $checkin->update(['status' => 'approved']);
        });
        return redirect()->route('checkins.index')->with('success', $createdPoint
            ? 'Đã duyệt check-in và tự động cộng điểm hoạt động.'
            : 'Đã duyệt check-in. Điểm hoạt động đã tồn tại nên không cộng trùng.');
    }
}
