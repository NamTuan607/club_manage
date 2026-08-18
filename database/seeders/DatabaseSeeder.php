<?php

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
            EventCategorySeeder::class,
            ActivityPointRuleSeeder::class,
            EventSeeder::class,
            EventActivitySeeder::class,
        ]);
    }
}
