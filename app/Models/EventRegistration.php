<?php
# Vai trò: Model Eloquent cho đăng ký sự kiện của sinh viên.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'student_id', 'registered_at', 'status'];

    protected $casts = ['registered_at' => 'datetime'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function checkin()
    {
        return $this->hasOne(CheckinLog::class,'registration_id');
    }
}
