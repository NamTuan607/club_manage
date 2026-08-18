<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    protected $fillable = [
    'name',
    'short_name',
    'logo',
    'description',
    'email',
    'phone',
    'location',
    'founding_date',
    'advisor',
    'president',
    'max_members',
    'status'
];
    use HasFactory;
    //
    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function roles()
    {
        return $this->hasMany(ClubRole::class);
    }
}
