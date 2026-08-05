<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    //
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class,'category_id');
    }

    public function approvals()
    {
        return $this->hasMany(EventApproval::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function studentPoints()
    {
        return $this->hasMany(StudentPoint::class);
    }
}
