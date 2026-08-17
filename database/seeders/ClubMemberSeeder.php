<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClubMember;
use App\Models\Club;
use App\Models\Student;
use App\Models\ClubRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ClubMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentCount = Student::count();

        if ($studentCount === 0) {
            $this->command->info('No students found in `students` table — skipping ClubMember seeding.');
            return;
        }

        $clubs = Club::all();
        if ($clubs->isEmpty()) {
            $this->command->info('No clubs found — ensure ClubSeeder ran.');
            return;
        }

        $roles = ClubRole::all();
        if ($roles->isEmpty()) {
            $this->command->info('No club roles found — ensure ClubRoleSeeder ran.');
            return;
        }

        // aim to create between 4 and 6 members
        $target = min(6, Student::count());
        $created = 0;

        $students = Student::inRandomOrder()->get();
        $clubs = $clubs->values();

        foreach ($students as $student) {
            if ($created >= 4 && $created >= $target) break;

            // pick a club that the student is not already a member of
            $availableClub = null;
            foreach ($clubs as $c) {
                $exists = ClubMember::where('student_id', $student->id)
                    ->where('club_id', $c->id)
                    ->exists();
                if (!$exists) {
                    $availableClub = $c;
                    break;
                }
            }

            if (!$availableClub) {
                continue; // student already member of all clubs (unlikely)
            }

            // choose role cyclically from existing roles
            $role = $roles->get($created % $roles->count());

            $joinDate = Carbon::now()->subMonths(rand(1, 36))->toDateString();

            try {
                $data = [
                    'club_id' => $availableClub->id,
                    'student_id' => $student->id,
                    'club_role_id' => $role->id,
                    'join_date' => $joinDate,
                    'status' => 'active'
                ];

                if (Schema::hasColumn('club_members', 'leave_date')) {
                    $data['leave_date'] = null;
                }

                if (Schema::hasColumn('club_members', 'academic_year')) {
                    $data['academic_year'] = Carbon::parse($joinDate)->format('Y').'-'.(Carbon::parse($joinDate)->format('Y')+1);
                }

                if (Schema::hasColumn('club_members', 'note')) {
                    $data['note'] = 'Seeded member';
                }

                ClubMember::create($data);

                $created++;
                $this->command->info("ClubMemberSeeder: created member for student_id={$student->id} club_id={$availableClub->id} role_id={$role->id}");
            } catch (\Exception $e) {
                $this->command->error('ClubMemberSeeder: failed to create member for student_id='.$student->id.' — '.$e->getMessage());
            }

            if ($created >= 6) break;
        }

        $this->command->info('ClubMemberSeeder: seeded '.$created.' members.');
    }
}
