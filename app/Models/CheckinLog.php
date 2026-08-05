<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckinLog extends Model
{
    use HasFactory;
    //
    public function registration()
    {
        return $this->belongsTo(EventRegistration::class,'registration_id');
    }
}
