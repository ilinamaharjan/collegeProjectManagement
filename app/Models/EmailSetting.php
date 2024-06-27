<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_to_creator',
        'mail_to_assignees',
        'module_type'
    ];

    public function setModuleTypeAttribute($value){
        $attribute_name = '';
        if ($value == 'pm') {
            $attribute_name = 'Project Management';
        } else {
            $attribute_name = 'Deal';
        }
        $this->attributes['module_type'] = $attribute_name;
    }
}
