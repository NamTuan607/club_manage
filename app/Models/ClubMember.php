<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubMember extends Model
{
    protected $fillable = [
        'club_id',
        'student_id',
        'club_role_id',
        'join_date',
        'leave_date',
        'status',
        'academic_year',
        'note'
    ];

    protected $casts = [
        'join_date' => 'date',
        'leave_date' => 'date',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function clubRole()
    {
        return $this->belongsTo(ClubRole::class);
    }
}
