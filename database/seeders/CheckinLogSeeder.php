<?php
# Vai trò: Mock data cho các lần check-in ở trạng thái chờ duyệt và đã duyệt.

namespace Database\Seeders;

use App\Models\CheckinLog;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Seeder;

class CheckinLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            ['Hiến máu nhân đạo', 1, 'approved'], ['Hiến máu nhân đạo', 2, 'approved'],
            ['Hiến máu nhân đạo', 3, 'pending'], ['Hiến máu nhân đạo', 4, 'pending'],
            ['Hoạt động tình nguyện vì cộng đồng', 5, 'approved'], ['Hoạt động tình nguyện vì cộng đồng', 6, 'approved'],
            ['Hoạt động tình nguyện vì cộng đồng', 7, 'approved'], ['Hoạt động tình nguyện vì cộng đồng', 8, 'pending'],
            ['Workshop kỹ năng lãnh đạo', 9, 'pending'], ['Workshop kỹ năng lãnh đạo', 10, 'pending'],
        ];

        foreach ($logs as [$title, $studentId, $status]) {
            $event = Event::where('title', $title)->firstOrFail();
            $registration = EventRegistration::where('event_id', $event->id)->where('student_id', $studentId)->firstOrFail();
            CheckinLog::updateOrCreate(
                ['registration_id' => $registration->id],
                ['checkin_time' => now()->subDays(5), 'status' => $status]
            );
        }
    }
}
