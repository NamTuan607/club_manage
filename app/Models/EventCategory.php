<?php
# Vai trò: Model Eloquent cho loại sự kiện và các quy tắc điểm tương ứng.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'max_points', 'status'];

    protected $casts = ['max_points' => 'integer'];
    public function events()
    {
        return $this->hasMany(Event::class,'category_id');
    }

    public function rules()
    {
        return $this->hasMany(ActivityPointRule::class);
    }
}
