<?php
# Vai trò: Mock data cho các loại sự kiện và mức điểm tối đa.

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Học thuật', 50], ['Thể thao', 50], ['Văn hóa - Văn nghệ', 40],
            ['Tình nguyện', 100], ['Kỹ năng', 50],
        ];

        foreach ($categories as [$name, $maxPoints]) {
            EventCategory::updateOrCreate(
                ['name' => $name],
                ['description' => 'Dữ liệu loại sự kiện dùng để demo.', 'max_points' => $maxPoints, 'status' => 'active']
            );
        }
    }
}
