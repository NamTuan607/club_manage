<?php
# Vai trò: Model Eloquent cho kết quả cán bộ phê duyệt sự kiện.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventApproval extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'approved_by', 'status', 'note', 'approved_at'];

    protected $casts = ['approved_at' => 'datetime'];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approved_by');
    }
}
