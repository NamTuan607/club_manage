<?php
# Vai trò: Mock data hồ sơ sinh viên, gồm đủ sinh viên để demo CLB 99/100.

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    public static function students(): array
    {
        $names = ['Nguyễn Văn An', 'Trần Thị Bình', 'Lê Văn Cường', 'Phạm Thị Dung', 'Hoàng Minh Đức', 'Đỗ Thu Hà', 'Bùi Quốc Hùng', 'Vũ Thị Lan', 'Ngô Đức Minh', 'Đặng Thu Trang'];
        $students = [];
        for ($number = 1; $number <= 102; $number++) {
            $students[] = [
                'email' => 'student' . $number . '@club.test',
                'student_code' => sprintf('SVDEMO%03d', $number),
                'full_name' => $names[$number - 1] ?? 'Sinh viên minh họa ' . $number,
                'class' => $number <= 10 ? '65TH' . (($number % 3) + 1) : '65DEMO',
                'faculty' => $number <= 10 ? 'Công nghệ thông tin' : 'Sinh viên demo',
                'phone' => '090000' . str_pad((string) $number, 4, '0', STR_PAD_LEFT),
            ];
        }

        return $students;
    }

    public function run(): void
    {
        foreach (self::students() as $student) {
            $user = User::where('email', $student['email'])->firstOrFail();
            unset($student['email']);
            Student::updateOrCreate(
                ['student_code' => $student['student_code']],
                $student + ['user_id' => $user->id]
            );
        }

        return;

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
