<?php
# Vai trò: Model Eloquent cho câu lạc bộ, sức chứa, thành viên, vai trò và sự kiện.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    protected $fillable = [
    'name',
    'short_name',
    'logo',
    'description',
    'email',
    'phone',
    'location',
    'founding_date',
    'advisor',
    'president',
    'max_members',
    'status'
];
    use HasFactory;
    //
    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function roles()
    {
        return $this->hasMany(ClubRole::class);
    }

    public function membershipRequests()
    {
        return $this->hasMany(MembershipRequest::class);
    }

    public function getMembersCountAttribute(): int
    {
        return $this->active_members_count ?? $this->members()->where('status', 'active')->count();
    }

    /**
     * Capacity is displayed with the terminology from the assignment while
     * retaining the existing max_members database column.
     */
    public function getCapacityAttribute(): int
    {
        return (int) $this->max_members;
    }
}
