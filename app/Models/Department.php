<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'user_id'
    ];

    public function user(){
        return $this->hasOne(User::class , 'user_id' , 'id');
    }
    public function company(){
        return $this->hasOne(Company::class , 'id' , 'company_id');
    }
}
