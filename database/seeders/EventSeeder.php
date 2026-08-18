<?php
# Vai trò: Mock data cho các sự kiện với trạng thái, thời gian và sức chứa phục vụ demo.

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            ['Hiến máu nhân đạo', 'CLB Tình nguyện', 'Tình nguyện', 30, 'approved', -14],
            ['Hoạt động tình nguyện vì cộng đồng', 'CLB Tình nguyện', 'Tình nguyện', 40, 'approved', -10],
            ['Workshop kỹ năng lãnh đạo', 'CLB Kỹ năng mềm', 'Kỹ năng', 50, 'approved', -7],
            ['Giải bóng chuyền sinh viên', 'CLB Bóng chuyền', 'Thể thao', 2, 'approved', 5],
            ['Ngày hội văn nghệ TLU', 'CLB Kỹ năng mềm', 'Văn hóa - Văn nghệ', 120, 'pending', 14],
            ['Chương trình học thuật sáng tạo', 'CLB Kỹ năng mềm', 'Học thuật', 80, 'rejected', 21],
        ];

        foreach ($events as [$title, $clubName, $categoryName, $capacity, $status, $days]) {
            $club = Club::where('name', $clubName)->firstOrFail();
            $category = EventCategory::where('name', $categoryName)->firstOrFail();
            $start = now()->startOfHour()->addDays($days);
            Event::updateOrCreate(
                ['title' => $title],
                ['club_id' => $club->id, 'category_id' => $category->id, 'description' => 'Sự kiện dữ liệu demo.', 'location' => 'Đại học Thủy Lợi', 'start_time' => $start, 'end_time' => $start->copy()->addHours(3), 'capacity' => $capacity, 'status' => $status]
            );
        }
    }
}
