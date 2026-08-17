<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'student')->take(6)->get();

        if ($users->isEmpty()) {
            $this->command->info('StudentsSeeder: no student-role users found — run UsersSeeder first.');
            return;
        }

        $samples = [
            ['student_code' => 'S2026001', 'full_name' => 'Nguyễn Văn A', 'class' => 'CNTT1', 'faculty' => 'CNTT', 'phone' => '0900000001'],
            ['student_code' => 'S2026002', 'full_name' => 'Trần Thị B', 'class' => 'CNTT2', 'faculty' => 'CNTT', 'phone' => '0900000002'],
            ['student_code' => 'S2026003', 'full_name' => 'Lê Văn C', 'class' => 'BONGDA1', 'faculty' => 'Thể thao', 'phone' => '0900000003'],
            ['student_code' => 'S2026004', 'full_name' => 'Phạm Thị D', 'class' => 'AMNHAC1', 'faculty' => 'Văn hóa', 'phone' => '0900000004'],
            ['student_code' => 'S2026005', 'full_name' => 'Hoàng Văn E', 'class' => 'CNTT3', 'faculty' => 'CNTT', 'phone' => '0900000005'],
            ['student_code' => 'S2026006', 'full_name' => 'Đỗ Thị F', 'class' => 'CNTT4', 'faculty' => 'CNTT', 'phone' => '0900000006'],
        ];

        $i = 0;
        foreach ($users as $user) {
            if (!isset($samples[$i])) break;
            $s = $samples[$i];

            Student::updateOrCreate(
                ['student_code' => $s['student_code']],
                [
                    'user_id' => $user->id,
                    'full_name' => $s['full_name'],
                    'class' => $s['class'],
                    'faculty' => $s['faculty'],
                    'phone' => $s['phone']
                ]
            );

            $i++;
        }

        $this->command->info('StudentsSeeder: seeded/updated '.$i.' students.');
    }
}
