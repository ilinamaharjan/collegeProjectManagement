<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_name',
        'field_type_id',
        'status',
        'html_element',
        'type',
        'company_id',
        'creator_user'
    ];

    public function dropdownOptions()
    {
        return $this->hasMany(DropdownOption::class);
    }
}
