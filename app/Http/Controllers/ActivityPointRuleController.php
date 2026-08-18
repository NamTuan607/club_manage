<?php
# Vai trò: Quản lý CRUD quy tắc cộng điểm hoạt động theo loại hoặc tên sự kiện.

namespace App\Http\Controllers;

use App\Models\ActivityPointRule;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class ActivityPointRuleController extends Controller
{
    public function index()
    {
        $rules = ActivityPointRule::with('category')->withCount('studentPoints')->latest()->paginate(10);

        return view('activity_point_rules.index', compact('rules'));
    }

    public function create()
    {
        return view('activity_point_rules.create', ['categories' => $this->categories()]);
    }

    public function store(Request $request)
    {
        ActivityPointRule::create($this->validated($request));

        return redirect()->route('activity-point-rules.index')->with('success', 'Đã thêm quy tắc cộng điểm.');
    }

    public function show(ActivityPointRule $activityPointRule)
    {
        $activityPointRule->load(['category', 'studentPoints.student', 'studentPoints.event']);

        return view('activity_point_rules.show', compact('activityPointRule'));
    }

    public function edit(ActivityPointRule $activityPointRule)
    {
        return view('activity_point_rules.edit', ['activityPointRule' => $activityPointRule, 'categories' => $this->categories()]);
    }

    public function update(Request $request, ActivityPointRule $activityPointRule)
    {
        $activityPointRule->update($this->validated($request));

        return redirect()->route('activity-point-rules.index')->with('success', 'Đã cập nhật quy tắc cộng điểm.');
    }

    public function destroy(ActivityPointRule $activityPointRule)
    {
        if ($activityPointRule->studentPoints()->exists()) {
            return back()->with('error', 'Không thể xóa quy tắc đã được dùng để cộng điểm.');
        }

        $activityPointRule->delete();

        return redirect()->route('activity-point-rules.index')->with('success', 'Đã xóa quy tắc cộng điểm.');
    }

    private function categories()
    {
        return EventCategory::where('status', 'active')->orderBy('name')->get();
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'event_category_id' => ['required', 'exists:event_categories,id'],
            'event_name' => ['nullable', 'string', 'max:255'],
            'points' => ['required', 'integer', 'min:1', 'max:1000'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category = EventCategory::findOrFail($data['event_category_id']);
        if ($data['points'] > $category->max_points) {
            abort(422, 'Điểm cộng không được vượt điểm tối đa của loại sự kiện.');
        }

        return $data;
    }
}
