<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'student_code', 'full_name', 'class', 'faculty', 'phone'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function points()
    {
        return $this->hasMany(StudentPoint::class);
    }

    public function membershipRequests()
    {
        return $this->hasMany(MembershipRequest::class);
    }
}
