<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_name',
        'heirarchy_order',
        'status_setting_id',
        'favcolor',
        'notifier',
        'company_id'
    ];

    public function tasks(){
        return $this->hasMany(Task::class,'status_id','id');
    }

    public function leads(){
        return $this->hasMany(Lead::class,'status_id','id');
    }

    public function status_setting(){
        return $this->belongsTo(StatusSetting::class,'status_setting_id','id');
    }
}
