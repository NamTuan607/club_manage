<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use App\Models\EventRegistration;
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
            'points' => StudentPoint::count(),
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
