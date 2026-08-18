<?php
# Vai trò: Model Eloquent cho lịch sử check-in của đăng ký sự kiện.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckinLog extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'checkin_time', 'status'];

    protected $casts = ['checkin_time' => 'datetime'];
    public function registration()
    {
        return $this->belongsTo(EventRegistration::class,'registration_id');
    }
}
