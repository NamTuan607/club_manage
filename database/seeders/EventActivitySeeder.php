<?php

namespace Database\Seeders;

use App\Models\ActivityPointRule;
use App\Models\Certificate;
use App\Models\CheckinLog;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Student;
use App\Models\StudentPoint;
use Illuminate\Database\Seeder;

class EventActivitySeeder extends Seeder
{
    public function run(): void
    {
        $registrations = [
            ['event' => 'Workshop Kỹ năng thuyết trình', 'student' => '2051006123', 'checked_in' => true],
            ['event' => 'Workshop Kỹ năng thuyết trình', 'student' => '2151006456', 'checked_in' => true],
            ['event' => 'Workshop Kỹ năng thuyết trình', 'student' => '2251006789', 'checked_in' => false],
            ['event' => 'Giải bóng đá sinh viên', 'student' => '2051006124', 'checked_in' => false],
            ['event' => 'Giải bóng đá sinh viên', 'student' => '2151006457', 'checked_in' => false],
        ];

        foreach ($registrations as $data) {
            $event = Event::where('title', $data['event'])->firstOrFail();
            $student = Student::where('student_code', $data['student'])->firstOrFail();
            $registration = EventRegistration::updateOrCreate(
                ['event_id' => $event->id, 'student_id' => $student->id],
                ['registered_at' => now()->subDays(2), 'status' => 'registered']
            );

            if ($data['checked_in']) {
                CheckinLog::firstOrCreate(
                    ['registration_id' => $registration->id],
                    ['checkin_time' => now()->subDays(5)->setTime(8, 15), 'status' => 'checked_in']
                );

                $rule = ActivityPointRule::where('event_category_id', $event->category_id)->firstOrFail();
                $point = StudentPoint::updateOrCreate(
                    ['student_id' => $student->id, 'event_id' => $event->id, 'rule_id' => $rule->id],
                    ['points' => $rule->points, 'awarded_at' => now()->subDays(5)->setTime(12, 0)]
                );

                if ($student->student_code === '2051006123') {
                    Certificate::updateOrCreate(
                        ['student_point_id' => $point->id],
                        ['certificate_code' => 'CN-DEMO-0001', 'issued_at' => now(), 'status' => 'valid']
                    );
                }
            }
        }
    }
}
