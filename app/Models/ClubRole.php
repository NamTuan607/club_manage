<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubRole extends Model
{
    protected $fillable = [
        'role_name',
        'description',
        'permission_level',
        'can_manage_members',
        'can_create_events',
        'can_approve_members'
    ];

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
}