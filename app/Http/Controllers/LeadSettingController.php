<?php

namespace App\Http\Controllers;

use App\Models\LeadSetting;
use App\Models\StatusSetting;
use App\Repositories\LeadSettingRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LeadSettingController extends Controller
{
    protected $leadsetting;

    public function __construct(LeadSettingRepositoryInterface $leadsetting) {
        $this->leadsetting= $leadsetting;
    }

    public function index(){
        $company_id = auth()->user()->company_id;
        $status_setting = StatusSetting::where('company_id',$company_id)->where('module_name','Like','Lead-Setting%')->with('leadSettings')->first();
        if ($status_setting == null) {
            $lead_settings = [];
        }else{
            $lead_settings = $status_setting['leadSettings'];
        }
        return view('backend.lead_setting.index',compact('lead_settings'));
    }

    public function create(){
        $status_setting = StatusSetting::where('module_name','LIKE','Lead-Setting%')->where('company_id',auth()->user()->company_id)->with('leadSettings')->first();
        if ($status_setting == null) {
            $setting_count = 0;
        } else {
            $setting_count = count($status_setting['leadSettings']);
        }
        $unique_name = null;
        if ($setting_count > 0) {
            $unique_name = $status_setting->module_name;
        }
        return view('backend.lead_setting.create',compact('unique_name'));
    }

    public function store(Request $request){
        $data = $request->all();
        $response = $this->leadsetting->store($data);
        if ($response['response'] == true) {
            Alert::success('Success',$response['message']);
            // return redirect()->route('lead_setting.index');
            return back();
        } else {
            Alert::error('Error',$response['message']);
            return back();
        }
        
    }
}
