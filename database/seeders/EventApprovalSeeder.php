<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventApproval;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventApprovalSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->value('id');
        foreach ([
            'Hiến máu nhân đạo' => 'approved',
            'Hoạt động tình nguyện vì cộng đồng' => 'approved',
            'Workshop kỹ năng lãnh đạo' => 'approved',
            'Giải bóng chuyền sinh viên' => 'approved',
            'Chương trình học thuật sáng tạo' => 'rejected',
        ] as $title => $status) {
            $event = Event::where('title', $title)->firstOrFail();
            EventApproval::updateOrCreate(
                ['event_id' => $event->id, 'approved_by' => $adminId],
                ['status' => $status, 'note' => $status === 'approved' ? 'Sự kiện được duyệt.' : 'Cần bổ sung kế hoạch.', 'approved_at' => now()->subDay()]
            );
        }
    }
}
