<?php

namespace App\Repositories;

use App\Models\LeadSetting;
use App\Models\StatusSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeadSettingRepository implements LeadSettingRepositoryInterface {
    public function store($data){
        try {
            $status_setting_id = (int)$data['statusSettingId'];
            $lead_setting_data = [];
            DB::transaction(function() use($status_setting_id,$data,$lead_setting_data){
                foreach ($data['status_name'] as $key => $sn) {
                    if (array_key_exists('first_radio'.$key,$data)) {
                        $notifier = $data['first_radio'.$key];
                        $heirarchy_order = null; 
                    }
                    else if (array_key_exists('last_radio'.$key,$data)) {
                        $notifier = $data['last_radio'.$key];
                        $heirarchy_order = null; 
                    }else{
                        $heirarchy_order = $data['heirarchy'.$key]; 
                        $notifier = null;
                    }
                    $lead_setting_data[] = [
                        'status_name' => $sn,
                        'heirarchy_order' => $heirarchy_order,
                        'status_setting_id' => $status_setting_id,
                        'favcolor' => $data['favcolor'][$key],
                        'notifier' => $notifier,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'company_id'=>auth()->user()->company_id,
                    ];
                }
                LeadSetting::insert($lead_setting_data);
            });
            return [
                'response' => true,
                'message' => 'Successfully added!'
            ];
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}