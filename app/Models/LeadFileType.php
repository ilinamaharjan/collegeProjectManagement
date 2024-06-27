<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'has_multiple',
        'creator_user',
        'company_id'
    ];
}
