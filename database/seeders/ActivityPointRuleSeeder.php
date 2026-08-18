<?php

namespace Database\Seeders;

use App\Models\ActivityPointRule;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class ActivityPointRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            ['category' => 'Học thuật', 'points' => 10, 'description' => 'Tham gia đầy đủ sự kiện học thuật.'],
            ['category' => 'Thể thao', 'points' => 8, 'description' => 'Tham gia đầy đủ hoạt động thể thao.'],
            ['category' => 'Văn hóa - Văn nghệ', 'points' => 7, 'description' => 'Tham gia đầy đủ chương trình văn hóa - văn nghệ.'],
            ['category' => 'Tình nguyện', 'points' => 12, 'description' => 'Hoàn thành hoạt động tình nguyện.'],
        ];

        foreach ($rules as $rule) {
            $category = EventCategory::where('name', $rule['category'])->firstOrFail();
            ActivityPointRule::updateOrCreate(
                ['event_category_id' => $category->id, 'description' => $rule['description']],
                ['points' => $rule['points']]
            );
        }
    }
}
