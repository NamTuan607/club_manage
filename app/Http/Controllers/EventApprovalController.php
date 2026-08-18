<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventApproval;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EventApprovalController extends Controller
{
    public function index()
    {
        $approvals = EventApproval::with(['event.club', 'approver'])->latest('approved_at')->paginate(10);
        $pendingEvents = Event::with('club')->where('status', 'pending')->orderBy('start_time')->get();
        return view('event_approvals.index', compact('approvals', 'pendingEvents'));
    }

    public function approve(Event $event)
    {
        $this->process($event, 'approved');
        return redirect()->route('event-approvals.index')->with('success', 'Đã duyệt sự kiện.');
    }

    public function reject(Event $event)
    {
        $this->process($event, 'rejected');
        return redirect()->route('event-approvals.index')->with('success', 'Đã từ chối sự kiện.');
    }

    public function show(EventApproval $eventApproval)
    {
        $eventApproval->load(['event.club', 'event.category', 'approver']);
        return view('event_approvals.show', compact('eventApproval'));
    }

    private function process(Event $event, string $status): void
    {
        DB::transaction(function () use ($event, $status) {
            $event = Event::lockForUpdate()->findOrFail($event->id);
            if ($event->status !== 'pending') {
                throw ValidationException::withMessages(['event' => 'Sự kiện này không còn chờ duyệt.']);
            }
            EventApproval::create([
                'event_id' => $event->id,
                'approved_by' => User::where('role', 'admin')->value('id'),
                'status' => $status,
                'approved_at' => now(),
            ]);
            $event->update(['status' => $status]);
        });
    }
}
