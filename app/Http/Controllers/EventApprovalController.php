<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventApproval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventApprovalController extends Controller
{
    public function index()
    {
        $approvals = EventApproval::with(['event.club', 'approver'])->latest('approved_at')->paginate(10);
        $pendingEvents = Event::with('club')->where('status', 'pending')->orderBy('start_time')->get();

        return view('event_approvals.index', compact('approvals', 'pendingEvents'));
    }

    public function create(Request $request)
    {
        $events = Event::with('club')->where('status', 'pending')->orderBy('start_time')->get();
        $approvers = User::where('role', 'admin')->orderBy('name')->get();
        $selectedEventId = $request->integer('event_id');

        return view('event_approvals.create', compact('events', 'approvers', 'selectedEventId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'approved_by' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:approved,rejected'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($data) {
            $event = Event::lockForUpdate()->findOrFail($data['event_id']);

            if ($event->status !== 'pending') {
                abort(422, 'Sự kiện này không còn chờ duyệt.');
            }

            EventApproval::create($data + ['approved_at' => now()]);
            $event->update(['status' => $data['status']]);
        });

        return redirect()->route('event-approvals.index')->with('success', 'Đã cập nhật kết quả duyệt sự kiện.');
    }

    public function show(EventApproval $eventApproval)
    {
        $eventApproval->load(['event.club', 'event.category', 'approver']);

        return view('event_approvals.show', compact('eventApproval'));
    }
}
