<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPoint extends Model
{
    use HasFactory;
    //
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function rule()
    {
        return $this->belongsTo(ActivityPointRule::class,'rule_id');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
