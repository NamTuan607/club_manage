<?php
# Vai trò: Model Eloquent cho chức vụ của thành viên trong câu lạc bộ.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubRole extends Model
{
    protected $fillable = [
        'club_id',
        'role_name',
        'description'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
}
