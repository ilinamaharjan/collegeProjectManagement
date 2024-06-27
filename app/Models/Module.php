<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'display_name',
        'creator_user_id',
        'parent_module_id',
        'status',
    ];

    public function subModules()
    {
        return $this->hasMany(Module::class, 'parent_module_id')->with('subModules');
    }
}