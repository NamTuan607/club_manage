<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['email' => 'an@tlu.edu.vn', 'student_code' => '2051006123', 'full_name' => 'Nguyễn Văn An', 'class' => '65TH1', 'faculty' => 'Công nghệ thông tin', 'phone' => '0987654321'],
            ['email' => 'binh@tlu.edu.vn', 'student_code' => '2151006456', 'full_name' => 'Trần Thị Bình', 'class' => '65TH2', 'faculty' => 'Công nghệ thông tin', 'phone' => '0987654322'],
            ['email' => 'cuong@tlu.edu.vn', 'student_code' => '2251006789', 'full_name' => 'Lê Văn Cường', 'class' => '65QT1', 'faculty' => 'Kinh tế và Quản lý', 'phone' => '0987654323'],
            ['email' => 'dung@tlu.edu.vn', 'student_code' => '2151006457', 'full_name' => 'Phạm Thị Dung', 'class' => '65TH2', 'faculty' => 'Công nghệ thông tin', 'phone' => '0987654324'],
            ['email' => 'duc@tlu.edu.vn', 'student_code' => '2051006124', 'full_name' => 'Hoàng Minh Đức', 'class' => '65TH1', 'faculty' => 'Công nghệ thông tin', 'phone' => '0987654325'],
            ['email' => 'ha@tlu.edu.vn', 'student_code' => '2151006458', 'full_name' => 'Đỗ Thu Hà', 'class' => '65TH2', 'faculty' => 'Công nghệ thông tin', 'phone' => '0987654326'],
        ];

        foreach ($students as $student) {
            $user = User::where('email', $student['email'])->firstOrFail();
            unset($student['email']);

            Student::updateOrCreate(
                ['student_code' => $student['student_code']],
                $student + ['user_id' => $user->id]
            );
        }
    }
}
