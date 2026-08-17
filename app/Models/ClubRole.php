<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubRole extends Model
{
    protected $fillable = [
        'role_name',
        'description'
    ];

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
}