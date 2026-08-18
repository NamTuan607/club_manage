<?php
# Vai trò: Mock data cho quy tắc cộng điểm hoạt động theo loại và tên sự kiện.

namespace Database\Seeders;

use App\Models\ActivityPointRule;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class ActivityPointRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            ['Tình nguyện', 'Hiến máu nhân đạo', 80, 'Hiến máu nhân đạo'],
            ['Tình nguyện', null, 30, 'Hoạt động tình nguyện'],
            ['Tình nguyện', 'Giúp đỡ cộng đồng', 50, 'Giúp đỡ cộng đồng'],
            ['Thể thao', null, 30, 'Tham gia thi đấu'],
            ['Thể thao', 'Cổ vũ đội tuyển', 20, 'Cổ vũ đội tuyển'],
            ['Kỹ năng', null, 40, 'Workshop kỹ năng'],
            ['Học thuật', null, 35, 'Hoạt động học thuật'],
            ['Văn hóa - Văn nghệ', null, 25, 'Hoạt động văn hóa - văn nghệ'],
        ];

        foreach ($rules as [$categoryName, $eventName, $points, $description]) {
            $category = EventCategory::where('name', $categoryName)->firstOrFail();
            ActivityPointRule::updateOrCreate(
                ['event_category_id' => $category->id, 'event_name' => $eventName],
                ['points' => $points, 'description' => $description]
            );
        }
    }
}
