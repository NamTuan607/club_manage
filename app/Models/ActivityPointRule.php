<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityPointRule extends Model
{
    use HasFactory;
    //
    public function category()
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function studentPoints()
    {
        return $this->hasMany(StudentPoint::class,'rule_id');
    }
}
