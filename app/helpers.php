<?php

use App\Models\User;
use App\Models\Module;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

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

function storeContactPerson($contact,$created_organization,$use_data,$organization){
    if ($contact['name'] != null) {
        $contact_data = [
            'name' => $contact['name'],
            'organization_id' => $created_organization['id'],
            'company_id' => auth()->user()->company_id,
            'additional_fields' => null,
            'creator_user' => auth()->id(),
            'is_primary' => 1,
        ];
        $contact_person = Contact::create($contact_data);
        if ($use_data) {
            $emails = $organization['email'];
            $numbers = $organization['number'];
            foreach ($emails as $key => $email) {
                DB::table('contact_email')->insert([
                    'contact_id' => $contact_person['id'],
                    'email' => $email
                ]);
            }
            foreach ($numbers as $key => $number) {
                DB::table('contact_phone')->insert([
                    'contact_id' => $contact_person['id'],
                    'phone_number' => $number
                ]);
            }
        }else {
            foreach ($contact['email'] as $key => $email) {
                if ($email == null) {
                    break;
                }else {
                    DB::table('contact_email')->insert([
                        'contact_id' => $contact_person['id'],
                        'email' => $email
                    ]);
                }
            }
            foreach ($contact['phone_number'] as $key => $ph) {
                if ($ph == null) {
                    break;
                }else {
                    DB::table('contact_phone')->insert([
                        'contact_id' => $contact_person['id'],
                        'phone_number' => $ph
                    ]);
                }
            }
        }
    }
    return $contact_person;
}

if (!function_exists('getModuleWisePermissions')) {
    function getModuleWisePermissions()
    {
         $modules = [];
        $company_name=Company::where('id',auth()->user()->company_id)->with('package','package.modules')->first();
        if($company_name){

            $permissions = Permission::all();
        if(Auth::user()->hasRole('Super Admin')){
            foreach ($permissions as $key => $permission) {
                $permissionName = explode('|', $permission->name);
                array_push($modules, $permissionName[1]);
            }
            
        }elseif(Auth::user()->hasRole('Admin')){
            foreach ($company_name['package']['modules'] as $key => $mod) {
                foreach ($permissions as $key => $permission) {

                    $permissionName = explode('|', $permission->name);
                    
                    if($permissionName[1]==$mod->name){
                        array_push($modules, $permissionName[1]);
                    }
                    if($permission->name=="Admin|Dashboard"){
                        array_push($modules, $permissionName[1]);
                    }
                }
                if (count($mod->subModules) > 0) {
                    foreach ($mod->subModules as $key => $sub_module) {
                        $sub_permissions = Permission::where('module_id',$sub_module['id'])->get();
                        foreach ($sub_permissions as $key => $s_permission) {
                            $permissionName = explode('|', $s_permission->name);
                            array_push($modules , $permissionName[1]);
                        }
                    }
                }
            }
        }else{
            $user=User::where('id',Auth::id())->with('roles','roles.permissions','permissions')->first();
            if(count($user['roles'])>0){
                foreach ($user['roles'] as $key => $value) {
                    foreach ($value['permissions'] as $key => $v) {
                        $permissionName = explode('|', $v->name);
                        
                            array_push($modules, $permissionName[1]);
                        
                        if($v->name=="Admin|Dashboard"){
                            array_push($modules, $permissionName[1]);
                        }
                    }
                }
            }
            if($user['permissions']){
                foreach ($user['permissions'] as $key => $v) {
                    $permissionName = explode('|', $v->name);
                    array_push($modules, $permissionName[1]);
                }
            }

        }
    
            $finalModules = array_unique($modules);
            $finalPermissions = [];
            $finalModu = [];
            foreach ($finalModules as $fm) {
                $finalModu['moduleName'] = $fm;
                $finalModu['action'] = [];
                foreach ($permissions as $permission) {
                    $permissionName = explode('|', $permission->name);
                    if ($permissionName[1] == $fm) {
                        array_push($finalModu['action'], ['id' => $permission->id, 'name' => $permissionName[0]]);
                    }
                }
                array_push($finalPermissions, $finalModu);
            }
            return collect($finalPermissions);
        }else{
            return $modules;
        }
        
    }
}
if (!function_exists('getCurrentPackagePermissions')) {
    function getCurrentPackagePermissions($company_package_id)
    {
        $package = Package::where('id',$company_package_id)->with('modules')->first();
        $permission_arr = [];
        foreach ($package->modules as $key => $module) {
            if ($module['name'] == 'Company') {
                $company_permissions = Permission::where('module_id',$module['id'])->where('name','!=','Create|Company')->where('name','!=','Delete|Company')->get();   
                foreach ($company_permissions as $key => $c_permission) {
                    array_push($permission_arr , $c_permission);
                }
            } else {
                $permissions = Permission::where('module_id',$module['id'])->get();
                foreach ($permissions as $key => $permission) {
                    array_push($permission_arr,$permission);
                }
                if (count($module->subModules) > 0) {
                    foreach ($module->subModules as $key => $sub_module) {
                        $sub_permissions = Permission::where('module_id',$sub_module['id'])->get();
                        foreach ($sub_permissions as $key => $s_permission) {
                            array_push($permission_arr , $s_permission);
                        }
                    }
                }
                
            }
        }
        return $permission_arr;
    }
}


?>