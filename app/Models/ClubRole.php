<?php

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
