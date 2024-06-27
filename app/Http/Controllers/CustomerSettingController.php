<?php

namespace App\Http\Controllers;

use App\Models\StatusSetting;
use App\Repositories\CustomerSettingRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerSettingController extends Controller
{
    protected $customersetting;

    public function __construct(CustomerSettingRepositoryInterface $customersetting) {
        $this->customersetting= $customersetting;
    }

    public function index(){
        $status_setting = StatusSetting::where('module_name','LIKE','Customer-Setting%')->where('company_id',auth()->user()->company_id)->with('customerSettings')->first();
        if ($status_setting == null) {
            $customer_settings = [];
        }else{
            $customer_settings = $status_setting['customerSettings'];
        }
        return view('backend.customer_setting.index',compact('customer_settings'));
    }

    public function create(){
        $status_setting = StatusSetting::where('module_name','LIKE','Customer-Setting%')->where('company_id',auth()->user()->company_id)->with('customerSettings')->first();
        if ($status_setting == null) {
            $setting_count = 0;
        } else {
            $setting_count = count($status_setting['customerSettings']);
        }
        $unique_name = null;
        if ($setting_count > 0) {
            $unique_name = $status_setting->module_name;
        }
        return view('backend.customer_setting.create',compact('unique_name'));
    }

    public function store(Request $request){
        $data = $request->all();
        $response = $this->customersetting->store($data);
        if ($response['response'] == true) {
            Alert::success('Success',$response['message']);
            return redirect()->route('customer_setting.index');
        } else {
            Alert::error('Error',$response['message']);
            return back();
        }
    }
}
