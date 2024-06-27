<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Lead extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'additional_description',
        'organization_id',
        'contact_id',
        'estimated_worth',
        'creator_user',
        'status_id',
        'is_converted',
        'converted_at',
        'expected_closure_date',
        'priority_level',
        'company_id'
    ];

    public function settings()
    {
        return $this->belongsTo(LeadSetting::class, 'status_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user', 'id');
    }

    public function activities()
    {
        return $this->hasMany(LeadActivity::class, 'lead_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(LeadFile::class, 'lead_id', 'id');
    }
}
