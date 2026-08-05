<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubRole extends Model
{
    use HasFactory;
    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }
}
