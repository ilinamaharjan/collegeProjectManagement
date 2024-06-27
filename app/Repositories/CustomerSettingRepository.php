<?php

namespace App\Repositories;

use App\Models\CustomerSetting;
use App\Models\StatusSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CustomerSettingRepository implements CustomerSettingRepositoryInterface {
    public function store($data)
    {
        try {
            if (array_key_exists('unique_name',$data)) {
                $unique_name = $data['unique_name'];                
            } else {
                $unique_name = 'Customer-Setting'.Str::random(8);
            }
            
            $company_id = auth()->user()->company_id;
            DB::transaction(function () use($data,$unique_name,$company_id) {
                $length = count($data['status_name']);
                for ($i=0; $i < $length; $i++) { 
                    $lead_data['unique_name'] = $unique_name;
                    $lead_data['status_name'] = $data['status_name'][$i];
                    $lead_data['heirarchy_order'] = $data['heirarchy_order'][$i];
                    CustomerSetting::create($lead_data);
                }

                StatusSetting::create([
                    'module_name' => $unique_name,
                    'company_id' => $company_id
                ]);

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