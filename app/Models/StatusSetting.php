<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'module'
    ];

    public function leadSettings(){
        return $this->hasMany(LeadSetting::class,'status_setting_id','id');
    }
    public function customerSettings(){
        return $this->hasMany(CustomerSetting::class,'unique_name','module_name');
    }
}
