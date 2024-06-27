<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'user_id',
        'website',
        'total_employees',
        'package_id',
        'company_code',
        'parent_id'
    ];

    public function departments(){
        return $this->hasMany(Department::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    public function users(){
        return $this->hasMany(User::class , 'company_id' , 'id');
    }
}
