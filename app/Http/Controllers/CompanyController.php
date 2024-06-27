<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use App\Models\Package;
use App\Models\LeadSetting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\StatusSetting;
use App\Rules\ImageValidation;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use App\Repositories\CompanyRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class CompanyController extends Controller
{
    protected $company,$common_controller;

    public function __construct(CompanyRepositoryInterface $company,CommonController $common_controller) {
        $this->company= $company;
        $this->common_controller= $common_controller;
    }
    
    public function delete(Company $company){
        try {
            $company->users()->delete();
            $company->delete();
            Alert::success('Success','Deleted Successfully');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Error',$th->getMessage());
            return back();
        }
    }

    public function updateModal(Company $company){
        $packages = Package::all();
        try {
            return response()->json([
                'page' => view('backend.components.updateCompany',compact('company','packages'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function viewCompanies(){
        $companies = Company::where('parent_id',auth()->user()->company_id)->get();
        return view('backend.company.viewAllCustomer',compact('companies'));
    }

    public function viewOwnCompany($id){
        try {
            $company = Company::where('id',$id)->with('package')->first();
            return response()->json([
                'page' => view('backend.components.getOwnCompany',compact('company'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function create(){
        $packages = Package::all();
        return view('backend.company.setup',compact('packages'));
    }

    public function storeAjax(Request $request){
        $data = $request->all();
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'total_employees' => ['required']
        ];
        try {
            $validation_res = $this->common_controller->validator($data,$rules);
            if ($validation_res['response'] == false) {
                throw new Exception($validation_res['error_message'], 1);
            }
            $db_res = DB::transaction(function() use($data){
                $data['company_code'] = $this->generateCompanyCode($data['name']);
                $data['user_id'] = auth()->id();
                $data['parent_id'] = auth()->user()->company_id;
                $company = Company::create($data);
                $status_setting_data = [
                    'company_id' => $company['id'],
                    'name' => 'Default',
                    'module' => 'lead'
                ];
                $status_setting = StatusSetting::create($status_setting_data);
                $lead_setting_arr = [
                    [
                        'status_name' => 'Pitching',
                        'heirarchy_order' => null,
                        'status_setting_id' => $status_setting['id'],
                        'notifier' => 'First',
                        'favcolor' => '#1c732a'
                    ],
                    [
                        'status_name' => 'Quotation Sent',
                        'heirarchy_order' => '1',
                        'status_setting_id' => $status_setting['id'],
                        'notifier' => null,
                        'favcolor' => '#6283e4'
                    ],
                    [
                        'status_name' => 'Contract Signed',
                        'heirarchy_order' => '2',
                        'status_setting_id' => $status_setting['id'],
                        'notifier' => null,
                        'favcolor' => '#e262e4'
                    ],
                    [
                        'status_name' => 'Completed',
                        'heirarchy_order' => null,
                        'status_setting_id' => $status_setting['id'],
                        'notifier' => 'Last',
                        'favcolor' => '#5ea66a'
                    ]
                ];
                foreach ($lead_setting_arr as $key => $lead_setting) {
                    LeadSetting::create($lead_setting);
                }
                if (array_key_exists('company-logo',$data)) {
                    $company->addMedia($data['company-logo'])->toMediaCollection('company-logo');
                }
                return $company;
            });
            Alert::success('Success','Created successfully!');
            return redirect()->route('profile.userPage',$db_res['id']);                
            
            // For Ajax
            // return response()->json([
            //     'response' => true,
            //     'message' => 'Company successfully added',
            //     'company_id' => $db_res['id']
            // ]);
        } catch (\Throwable $th) {
            Alert::error('Error',$th->getMessage());
            return back();
        }
    }

    function generateCompanyCode($name){
        $exploded_name = explode(' ',$name);
        $abbreviated_name = '';
    
        if (count($exploded_name) > 1) {
            foreach ($exploded_name as $key => $en) {
                $abbreviated_name .= $en[0];
            }
        } else {
            $first_character = strtoupper($name[0]);
            $last_character = strtoupper($name[-1]);
            if (strlen($name) > 4) {
                $name_arr = str_split($name,1);
                $arr = array_slice($name_arr,1,-1);
                $middle_character = strtoupper($arr[rand(1,count($arr)-1)]);
                $abbreviated_name = $first_character.$middle_character.$last_character;
            }else {
                $abbreviated_name = $first_character.$last_character;
            }
        }
        return $abbreviated_name;
    }

    public function update(Request $request){
        $data = $request->all();
        
        try {
            $company = Company::where('id',$data['id'])->first();
            $modified_data = Arr::except($data,['id','_token']);
            DB::transaction(function () use($company,$modified_data,$data) {
                if($company->package_id==$data['package_id']){
                    $company->update($modified_data);   
                }else{
                    $company->update($modified_data);  
                    $newPackagePermissions=getCurrentPackagePermissions($company->package_id);
                    $newPackagePermissionsIds=[];
                    foreach ($newPackagePermissions as $key => $per) {
                        array_push($newPackagePermissionsIds,$per->id);
                    }
                  
                    // for role wise permission 
                    $this->RoleWisePermission($company->id,$newPackagePermissionsIds);

                    // // for user wise permission 
                    $this->UserWisePermission($company->id,$newPackagePermissionsIds);
                    
                }
                if (array_key_exists('company-logo',$modified_data)) {
                    if ($company->hasMedia('company-logo')) {
                        $company->deleteMedia($company->media[0]['id']);
                    }
                    $company->addMedia($modified_data['company-logo'])->toMediaCollection('company-logo');
                }
            });
            Alert::success('Success','Configuration changed');
            return back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function RoleWisePermission($companyId,$newPackagePermissionsIds){
          // for dashboard 
          $adminDashboard=Permission::where('name','Admin|Dashboard')->first();
          array_push($newPackagePermissionsIds , $adminDashboard->id);
        $roles=Role::where('company_id',$companyId)->with('permissions')->get();
        foreach($roles as $role){
            $getRole=Role::where('id',$role->id)->first();
            if($role->name=="Admin"){
                DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
                $getRole->syncPermissions($newPackagePermissionsIds);
            }else{
                foreach ($role->permissions as $key => $rp) {
                    if(in_array(!$rp->id,$newPackagePermissionsIds)){
                        DB::table('role_has_permissions')->where('role_id', $role->id)->where('permission_id',$rp->id)->delete();
                    }
                }
            }
        }
    }
    public function UserWisePermission($companyId,$newPackagePermissionsIds){
        $users=User::where('company_id',$companyId)->with('permissions')->get();
        foreach($users as $user){
            foreach ($user->permissions as $key => $rp) {
                if(in_array(!$rp->id,$newPackagePermissionsIds)){
                    DB::table('model_has_permissions')->where('model_id', $user->id)->where('permission_id',$rp->id)->delete();
                }
            }
        }
    }

    public function store(Request $request){
        $validation_res = $this->validation($request->all());
        if ($validation_res['response'] == false) {
            // Alert::error('Error', $validation_res['error_message']);
            dd($validation_res['error_message']);
            return back();
        }else {
            $res = $this->company->store($request->all()); 
            if ($res['response'] == true) {

                return view('backend.company.userCreate');
            }else {
                // Alert::toast('Warning',$res['message']);
                dd($res['message']);
                return back();
            }
        }
    }

    public function validation($data)
    {
        $common_controller = new CommonController();

        $rules = [
            'name' => ['required'],
            'email'=>['required'],
            'phone_number'=>['required'],
            'address'=>['required'],
            'img' => array_key_exists('img',$data) ? [new ImageValidation($data['img'],['jpg', 'png', 'jpeg'])] : []
        ];

        return $common_controller->validator($data, $rules);
    }
}
