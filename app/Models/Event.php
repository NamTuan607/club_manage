<?php
# Vai trò: Model Eloquent cho sự kiện, phê duyệt, đăng ký và điểm hoạt động liên quan.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id', 'category_id', 'title', 'description', 'location',
        'start_time', 'end_time', 'capacity', 'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'capacity' => 'integer',
    ];
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

    public function latestApproval()
    {
        return $this->hasOne(EventApproval::class)->latestOfMany('approved_at');
    }
}
