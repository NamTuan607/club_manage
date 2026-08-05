<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;
    //
    public function studentPoint()
    {
        return $this->belongsTo(StudentPoint::class);
    }
}
