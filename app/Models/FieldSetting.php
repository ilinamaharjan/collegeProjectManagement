<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'html_value'
    ];

}
