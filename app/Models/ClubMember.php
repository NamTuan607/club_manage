<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMember extends Model
{
    use HasFactory;
    //
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function role()
    {
        return $this->belongsTo(ClubRole::class,'club_role_id');
    }
}
