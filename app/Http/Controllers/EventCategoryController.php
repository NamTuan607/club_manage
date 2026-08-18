<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::withCount(['events', 'rules'])->orderBy('name')->paginate(10);

        return view('event_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('event_categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        EventCategory::create($data);

        return redirect()->route('event-categories.index')->with('success', 'Đã thêm loại sự kiện.');
    }

    public function show(EventCategory $eventCategory)
    {
        $eventCategory->load(['events.club', 'rules']);

        return view('event_categories.show', compact('eventCategory'));
    }

    public function edit(EventCategory $eventCategory)
    {
        return view('event_categories.edit', compact('eventCategory'));
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $data = $this->validated($request, $eventCategory->id);
        $eventCategory->update($data);

        return redirect()->route('event-categories.index')->with('success', 'Đã cập nhật loại sự kiện.');
    }

    public function destroy(EventCategory $eventCategory)
    {
        if ($eventCategory->events()->exists() || $eventCategory->rules()->exists()) {
            return back()->with('error', 'Không thể xóa loại sự kiện đang được sử dụng.');
        }

        $eventCategory->delete();

        return redirect()->route('event-categories.index')->with('success', 'Đã xóa loại sự kiện.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $unique = 'unique:event_categories,name';
        if ($ignoreId) {
            $unique .= ',' . $ignoreId;
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:100', $unique],
            'description' => ['nullable', 'string', 'max:1000'],
            'max_points' => ['required', 'integer', 'min:1', 'max:1000'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
