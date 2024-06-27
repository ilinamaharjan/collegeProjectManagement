<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'company_id',
        'creator_user',
        'additional_fields',
        'deal_type'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'organization_id', 'id');
    }



    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function deals(){
        return $this->hasMany(Lead::class,'organization_id','id');
    }
}
