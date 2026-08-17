<?php

namespace Database\Seeders;

use Database\Seeders\ClubSeeder;
use Database\Seeders\ClubRoleSeeder;
use Database\Seeders\ClubMemberSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\StudentsSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            StudentsSeeder::class,
            ClubRoleSeeder::class,
            ClubSeeder::class,
            ClubMemberSeeder::class,
        ]);
    }
}