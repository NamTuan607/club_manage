<?php
# Vai trò: Model Eloquent cho quy tắc cộng điểm hoạt động và quan hệ với loại sự kiện.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityPointRule extends Model
{
    use HasFactory;

    protected $fillable = ['event_category_id', 'event_name', 'points', 'description'];

    protected $casts = ['points' => 'integer'];
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function studentPoints()
    {
        return $this->hasMany(StudentPoint::class,'rule_id');
    }
}
