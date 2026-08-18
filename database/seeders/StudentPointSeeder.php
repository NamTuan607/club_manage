<?php

namespace Database\Seeders;

use App\Models\ActivityPointRule;
use App\Models\Event;
use App\Models\StudentPoint;
use Illuminate\Database\Seeder;

class StudentPointSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Hiến máu nhân đạo' => [1, 2],
            'Hoạt động tình nguyện vì cộng đồng' => [5, 6, 7],
        ] as $title => $studentIds) {
            $event = Event::with('category')->where('title', $title)->firstOrFail();
            $rule = ActivityPointRule::where('event_category_id', $event->category_id)
                ->where('event_name', $title)->first()
                ?? ActivityPointRule::where('event_category_id', $event->category_id)->whereNull('event_name')->firstOrFail();
            foreach ($studentIds as $studentId) {
                StudentPoint::updateOrCreate(
                    ['student_id' => $studentId, 'event_id' => $event->id],
                    ['rule_id' => $rule->id, 'points' => $rule->points, 'awarded_at' => now()->subDays(5)]
                );
            }
        }
    }
}
