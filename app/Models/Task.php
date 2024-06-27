<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'deadline',
        'is_completed',
        'company_id',
        'creator_user',
        'status_id',
        'is_assigned',
        'parent_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function histories(){
        return $this->hasMany(StatusHistory::class,'task_id','id');
    }

    public function setting(){
        return $this->belongsTo(LeadSetting::class,'status_id','id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'tasks_users');
    }
}
