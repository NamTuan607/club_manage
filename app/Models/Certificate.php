<?php
# Vai trò: Model Eloquent cho chứng nhận được cấp từ bản ghi điểm hoạt động.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['student_point_id', 'certificate_code', 'issued_at', 'status'];

    protected $casts = ['issued_at' => 'datetime'];
    public function studentPoint()
    {
        return $this->belongsTo(StudentPoint::class);
    }
}
