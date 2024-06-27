<?php

namespace App\Models;

use App\Models\LeadSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity',
        'deadline',
        'status',
        'creator_user',
        'lead_id',
        'status_id',
        'activity_type_id'
    ];

    public function leadSetting()
    {
        return $this->belongsTo(LeadSetting::class, 'status_id', 'id');
    }
}
