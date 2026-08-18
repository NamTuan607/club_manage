<?php
# Vai trò: Mock data cho các chứng nhận demo dựa trên điểm hoạt động đã có.

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\StudentPoint;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        StudentPoint::orderBy('id')->take(3)->get()->each(function (StudentPoint $point, int $index) {
            Certificate::updateOrCreate(
                ['student_point_id' => $point->id],
                ['certificate_code' => 'CERT-DEMO-00' . ($index + 1), 'issued_at' => now()->subDay(), 'status' => 'valid']
            );
        });
    }
}
