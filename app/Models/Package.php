<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'no_of_users',
        'subscription_mode',
        'is_specific',
        'price_per_user'
    ];

    public function modules(){
        return $this->belongsToMany(Module::class,'module_package');
    } 

    public function company(){
        return $this->hasMany(Company::class,'package_id','id');
    }
}
