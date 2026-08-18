<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Event;
use App\Models\EventApproval;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            ['title' => 'Workshop Kỹ năng thuyết trình', 'club' => 'CLB Kỹ năng mềm', 'category' => 'Học thuật', 'description' => 'Workshop giúp sinh viên nâng cao kỹ năng thuyết trình tự tin và hiệu quả.', 'location' => 'Hội trường T45 - Đại học Thủy Lợi', 'start_time' => now()->subDays(5)->setTime(8, 0), 'end_time' => now()->subDays(5)->setTime(11, 30), 'capacity' => 150, 'status' => 'completed'],
            ['title' => 'Giải bóng đá sinh viên', 'club' => 'CLB Bóng đá', 'category' => 'Thể thao', 'description' => 'Giải bóng đá giao hữu dành cho sinh viên các khoa.', 'location' => 'Sân vận động TLU', 'start_time' => now()->addDays(7)->setTime(14, 0), 'end_time' => now()->addDays(7)->setTime(17, 30), 'capacity' => 80, 'status' => 'approved'],
            ['title' => 'Ngày hội tình nguyện 2026', 'club' => 'CLB Tình nguyện', 'category' => 'Tình nguyện', 'description' => 'Chương trình dọn vệ sinh khuôn viên và hỗ trợ cộng đồng.', 'location' => 'Khuôn viên Đại học Thủy Lợi', 'start_time' => now()->addDays(10)->setTime(7, 0), 'end_time' => now()->addDays(10)->setTime(11, 0), 'capacity' => 100, 'status' => 'pending'],
            ['title' => 'Gala âm nhạc sinh viên', 'club' => 'CLB Kỹ năng mềm', 'category' => 'Văn hóa - Văn nghệ', 'description' => 'Đêm giao lưu văn nghệ sinh viên.', 'location' => 'Hội trường T35', 'start_time' => now()->addDays(15)->setTime(18, 0), 'end_time' => now()->addDays(15)->setTime(21, 0), 'capacity' => 120, 'status' => 'rejected'],
        ];

        foreach ($events as $data) {
            $club = Club::where('name', $data['club'])->firstOrFail();
            $category = EventCategory::where('name', $data['category'])->firstOrFail();
            unset($data['club'], $data['category']);

            Event::updateOrCreate(
                ['title' => $data['title']],
                $data + ['club_id' => $club->id, 'category_id' => $category->id]
            );
        }

        $officer = User::where('email', 'canbo@tlu.edu.vn')->firstOrFail();
        foreach (['Workshop Kỹ năng thuyết trình' => 'approved', 'Giải bóng đá sinh viên' => 'approved', 'Gala âm nhạc sinh viên' => 'rejected'] as $title => $status) {
            $event = Event::where('title', $title)->firstOrFail();
            EventApproval::updateOrCreate(
                ['event_id' => $event->id, 'approved_by' => $officer->id],
                ['status' => $status, 'note' => $status === 'approved' ? 'Sự kiện đáp ứng kế hoạch hoạt động.' : 'Cần bổ sung kế hoạch tổ chức chi tiết.', 'approved_at' => now()->subDay()]
            );
        }
    }
}
