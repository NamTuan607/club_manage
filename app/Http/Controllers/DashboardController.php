<?php
# Vai trò: Lấy số liệu thật từ cơ sở dữ liệu để hiển thị Dashboard quản trị.

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Certificate;
use App\Models\CheckinLog;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\MembershipRequest;
use App\Models\Student;
use App\Models\StudentPoint;

class DashboardController extends Controller
{
    public function index()
    {
        $statistics = [
            'clubs' => Club::count(),
            'students' => Student::count(),
            'events' => Event::count(),
            'registrations' => EventRegistration::where('status', 'registered')->count(),
            'checkins' => CheckinLog::count(),
            'points' => StudentPoint::sum('points'),
            'certificates' => Certificate::count(),
            'pending_memberships' => MembershipRequest::where('status', 'pending')->count(),
            'pending_events' => Event::where('status', 'pending')->count(),
            'pending_checkins' => CheckinLog::where('status', 'pending')->count(),
        ];

        $upcomingEvents = Event::with('club', 'category')
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $recentRegistrations = EventRegistration::with('event', 'student')
            ->latest('registered_at')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('statistics', 'upcomingEvents', 'recentRegistrations'));
    }
}
