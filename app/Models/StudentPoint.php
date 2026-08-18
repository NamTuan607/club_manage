<?php
# Vai trò: Model Eloquent cho điểm hoạt động được cộng từ check-in đã duyệt.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPoint extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'event_id', 'rule_id', 'points', 'awarded_at'];

    protected $casts = ['awarded_at' => 'datetime', 'points' => 'integer'];
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
