<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['club', 'category'])
            ->withCount(['registrations as registered_count' => fn ($query) => $query->where('status', 'registered')])
            ->latest('start_time')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create', $this->formData());
    }

    public function store(Request $request)
    {
        Event::create($this->validated($request) + ['status' => 'pending']);

        return redirect()->route('events.index')->with('success', 'Đã tạo sự kiện. Sự kiện đang chờ duyệt.');
    }

    public function show(Event $event)
    {
        $event->load([
            'club', 'category', 'approvals.approver',
            'registrations.student', 'registrations.checkin', 'studentPoints.student',
        ]);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', ['event' => $event] + $this->formData());
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validated($request) + ['status' => 'pending']);

        return redirect()->route('events.show', $event)
            ->with('success', 'Đã cập nhật sự kiện và chuyển về trạng thái chờ duyệt.');
    }

    public function destroy(Event $event)
    {
        if ($event->registrations()->exists() || $event->studentPoints()->exists()) {
            return back()->with('error', 'Không thể xóa sự kiện đã có đăng ký hoặc điểm hoạt động.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Đã xóa sự kiện.');
    }

    private function formData(): array
    {
        return [
            'clubs' => Club::where('status', 'active')->orderBy('name')->get(),
            'categories' => EventCategory::where('status', 'active')->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'club_id' => ['required', 'exists:clubs,id'],
            'category_id' => ['required', 'exists:event_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'location' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);
    }
}
