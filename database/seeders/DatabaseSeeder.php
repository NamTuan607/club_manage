<?php
# Vai trò: Điều phối thứ tự chạy toàn bộ seeder mock data của website.

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            StudentsSeeder::class,
            ClubSeeder::class,
            ClubRoleSeeder::class,
            ClubMemberSeeder::class,
            MembershipRequestSeeder::class,
            EventCategorySeeder::class,
            EventSeeder::class,
            EventApprovalSeeder::class,
            EventRegistrationSeeder::class,
            CheckinLogSeeder::class,
            ActivityPointRuleSeeder::class,
            StudentPointSeeder::class,
            CertificateSeeder::class,
        ]);
    }
}
