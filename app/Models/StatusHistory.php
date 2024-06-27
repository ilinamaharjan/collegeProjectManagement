<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'from_status',
        'to_status',
        'creator_user',
        'task_id'
    ];

    public function from(){
        return $this->belongsTo(LeadSetting::class,'from_status','id');
    }

    public function to(){
        return $this->belongsTo(LeadSetting::class,'to_status','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator_user','id');
    }
}
