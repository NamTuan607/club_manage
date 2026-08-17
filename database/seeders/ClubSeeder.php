<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubs = [
            [
                'name' => 'CLB Công nghệ thông tin',
                'short_name' => 'ITC',
                'logo' => 'clubs/it.png',
                'description' => 'Câu lạc bộ Công nghệ thông tin',

                'email' => 'itclub@tlu.edu.vn',
                'phone' => '0988888888',
                'location' => 'A2-305',

                'founding_date' => '2019-09-15',

                'advisor' => 'TS. Trần Văn B',
                'president' => 'Nguyễn Văn A',

                'max_members' => 200,

                'status' => 'active',
            ],

            [
                'name' => 'CLB Bóng đá',
                'short_name' => 'FC',
                'logo' => 'clubs/football.png',
                'description' => 'Câu lạc bộ Bóng đá',

                'email' => 'football@tlu.edu.vn',
                'phone' => '0988111111',
                'location' => 'Sân vận động',

                'founding_date' => '2018-08-20',

                'advisor' => 'ThS. Lê Văn D',
                'president' => 'Trần Văn C',

                'max_members' => 120,

                'status' => 'active',
            ],

            [
                'name' => 'CLB Âm nhạc',
                'short_name' => 'MUSIC',
                'logo' => 'clubs/music.png',
                'description' => 'Câu lạc bộ Âm nhạc',

                'email' => 'music@tlu.edu.vn',
                'phone' => '0988222222',
                'location' => 'Hội trường A',

                'founding_date' => '2020-10-12',

                'advisor' => 'TS. Nguyễn Văn F',
                'president' => 'Lê Văn E',

                'max_members' => 80,

                'status' => 'active',
            ]
        ];

        foreach ($clubs as $c) {
            Club::updateOrCreate(
                ['name' => $c['name']],
                $c
            );
        }
    }
}