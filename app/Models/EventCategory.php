<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventCategory extends Model
{
    use HasFactory;
    //
    public function events()
    {
        return $this->hasMany(Event::class,'category_id');
    }

    public function rules()
    {
        return $this->hasMany(ActivityPointRule::class);
    }
}
