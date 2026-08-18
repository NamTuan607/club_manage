<?php
# Vai trò: Mock data cho đăng ký sự kiện của sinh viên.

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Seeder;

class EventRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = [
            'Hiến máu nhân đạo' => [1, 2, 3, 4],
            'Hoạt động tình nguyện vì cộng đồng' => [5, 6, 7, 8],
            'Workshop kỹ năng lãnh đạo' => [9, 10, 11, 12, 13],
            'Giải bóng chuyền sinh viên' => [14, 15],
        ];

        foreach ($registrations as $title => $studentIds) {
            $event = Event::where('title', $title)->firstOrFail();
            foreach ($studentIds as $studentId) {
                EventRegistration::updateOrCreate(
                    ['event_id' => $event->id, 'student_id' => $studentId],
                    ['registered_at' => now()->subDays(2), 'status' => 'registered']
                );
            }
        }
    }
}
