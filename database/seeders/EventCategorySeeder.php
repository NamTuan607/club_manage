<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Học thuật', 'description' => 'Các sự kiện học thuật, hội thảo và cuộc thi chuyên môn.', 'max_points' => 50, 'status' => 'active'],
            ['name' => 'Thể thao', 'description' => 'Các hoạt động rèn luyện thể chất và thi đấu thể thao.', 'max_points' => 40, 'status' => 'active'],
            ['name' => 'Văn hóa - Văn nghệ', 'description' => 'Các hoạt động văn hóa, nghệ thuật và biểu diễn.', 'max_points' => 30, 'status' => 'active'],
            ['name' => 'Tình nguyện', 'description' => 'Các chương trình thiện nguyện, hỗ trợ cộng đồng.', 'max_points' => 50, 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            EventCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
