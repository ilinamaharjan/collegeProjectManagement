<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_name',
        'heirarchy_order',
        'unique_name'
    ];
}
