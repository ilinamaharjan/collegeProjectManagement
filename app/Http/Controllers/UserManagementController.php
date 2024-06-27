<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use App\Notifications\SendCredentialsToUser;

class UserManagementController extends Controller
{
    public function getAllUsers(){
        $users=User::where('company_id',auth()->user()->company_id)->get();
        try {
            if(Auth::user()->hasRole('Super Admin')){
                $users=User::with('permissions')->get();
                $no_of_users='Super Admin';
    
            }else{
                $total_users=Company::where('id',auth()->user()->company_id)->with('package')->first();
                $no_of_users=$total_users['package']->no_of_users;
            }
            return response()->json([
                'response'=>true,
                'users'=>view('backend.user_management.components.userTableList',compact('users','no_of_users'))->render(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
        // if(Auth::user()->hasRole('Super Admin')){
        //     $users=User::with('permissions')->get();
        //     $no_of_users='Super Admin';

        // }else{
        //     $total_users=Company::where('id',auth()->user()->company_id)->with('package')->first();
        //     $no_of_users=$total_users['package']->no_of_users;
        // }
        // return view('backend.user_management.index',compact('users','no_of_users'));
    }
    public function index(){
        $users=User::where('company_id',auth()->user()->company_id)->get();
        if(Auth::user()->hasRole('Super Admin')){
            $users=User::all();
            $no_of_users='Super Admin';

        }else{
            $total_users=Company::where('id',auth()->user()->company_id)->first();
            $no_of_users=$total_users['package']->no_of_users;
        }
        return view('backend.user_management.index',compact('users','no_of_users'));
    }
    public function create(){
        $roles=Role::where('company_id',auth()->user()->company_id)->get();
        return view('backend.user_management.create',compact('roles'));
    }

    public function store(Request $request){
        $data = $request->all();
        if(!(Auth::user()->hasRole('Super Admin'))){

            $total_users=Company::where('id',auth()->user()->company_id)->with('package')->first();
            $no_of_users=$total_users['package']->no_of_users;
            $users=User::where('company_id',auth()->user()->company_id)->get();
            if(count($users)>=$no_of_users){
                Alert::error('Error','You can not create more then ' .$no_of_users .' users');
                return back();
            }
        }
        try {
            DB::transaction(function () use($data) {

                $company_code = Company::where('id',auth()->user()->company_id)->pluck('company_code')->first();
                $password = Str::random(8);
                $data['password'] = bcrypt($password);
                $data['username'] = $company_code.'-'.$data['username'];
                $data['company_id']=auth()->user()->company_id;
                $user = User::create($data);
                if (array_key_exists('photo',$data)) {
                    $user->addMedia($data['photo'])->toMediaCollection('profile-photo');
                }
                $company = Company::where('id',auth()->user()->company_id)->first();
                
                $mail_data = [
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'password' => $password,
                    'company' => $company,
                    'id' => $user['id']
                ];
                // dd($data);

                // role and permission 
                if (array_key_exists('role_id',$data) && $data['role_id']!=null) {
                    $role=Role::findOrFail($data['role_id']);
                   $user->assignRole($role);
                }
                if (array_key_exists('permissions',$data)) {
                    $user->givePermissionTo($data['permissions']);
                }
               
               
                $user->notify(new SendCredentialsToUser($mail_data));

            });

            Alert::toast('User Created Successfully!','success');
            return redirect()->route('user_management.index');
        } catch (\Throwable $th) {
            Alert::error('Error',$th->getMessage());
            return back();
        }
    }

    public function getPermission(Request $request){
        $roleId=$request->roleId;
        $role=null;
        if($roleId){
            $role=Role::findOrFail($roleId);
        }
        return response()->json([
            'view'=>view('backend.components.viewRoleWisePermission',compact('role'))->render(),
            'status'=>true
        ]);

    }
    public function getPermissionUpdate(Request $request){
        $roleId=$request->roleId;
        $userId=$request->userId;
        $role=null;
        if($roleId){
            $role=Role::findOrFail($roleId);
        }
        $user=User::findOrFail($userId);
        $user_permission=[];
        foreach ($user['permissions'] as $key => $per) {
            array_push($user_permission,$per->id);
        }

        return response()->json([
            'view'=>view('backend.components.editRoleWisePermission',compact('role','user','user_permission'))->render(),
            'status'=>true
        ]);

    }
    public function viewPermissionOfUser(User $user){
      
            $newPermissionForUser=[];

            $userRolePermission=count($user->roles)>0 ? $user->roles[0]:null;
            if($userRolePermission){
                $userRoleAllPermissions=$userRolePermission->permissions;
                if($userRoleAllPermissions && count($userRoleAllPermissions)){
                    foreach ($userRoleAllPermissions as $key => $value) {
                        array_push($newPermissionForUser,$value->id);
                    }
                }
            }

            $userPermission=$user->permissions;
            if(count($userPermission)){
                foreach ($userPermission as $key => $value) {
                array_push($newPermissionForUser,$value->id);
                }
            }
            $latestPermissions = array_unique($newPermissionForUser);
            $permission_of_users=Permission::whereIn('id',$latestPermissions)->get();
        try {
            return response()->json([
                'page' => view('backend.components.viewUsersAllPermission', compact('user','permission_of_users'))->render(),
                'response' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'response' => false
            ]);
        }
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        try {
            if ($user) {
                $contact=Contact::where('creator_user',$user['id'])->get();
                if(count($contact)>0){
                    return response()->json([
                        'response'=>false,
                        'message'=>'Sorry, This user create contact book, We can not delete, First Delete those contact book! ',
                    ]);
                }

                $user->delete();
                return response()->json([
                    'response'=>true,
                    'message'=>'User Deleted SuccessFully',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
       
        // $user = User::where('id', $id)->first();
        // if ($user) {
        //     $user->delete();
        //     Alert::success('Success', 'User  Deleted');
            
        // } else {
        //     Alert::error('Error', 'No such Role');
        // }
        // return back();
    }

    public function userInfoEdit(User $user){
        try {
            return response()->json([
                'response'=>true,
                'page'=>view('backend.user_management.components.userInfoEdit',compact('user'))->render(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>true,
                'message'=>$th->getMessage(),
            ]);
        }
    }
    public function updateUser(Request $request){
        $data=$request->all();
        try {
            $user= User::find($data['user_id']);
            DB::transaction(function () use($data,$user) {
                $user->update([
                'name'=> $data['name'],
                'email'=> $data['email'],
                'personal_number'=> $data['personal_number'],
                'office_number'=> $data['office_number'],
                'permanent_address'=> $data['permanent_address'],
                'temporary_address'=> $data['temporary_address'],
                'designation'=> $data['designation'],
                ]);  
            });
            if(array_key_exists('photo',$data)){
                if($user->hasMedia('profile-photo')){
                    $user->clearMediaCollection('profile-photo');
                }
                $user->addMedia($data['photo'])->toMediaCollection('profile-photo');
            }
            Alert::success('Success','User Updated Successfully');
            return back();
        } catch (\Throwable $th) {
            Alert::error('Error',$th->getMessage());
            return back();
        }
    }
    public function userStatusUpdate(Request $request){
        $data=$request->all();
        try {
            $user= User::find($data['id']);
            DB::transaction(function () use($data,$user) {
                $user->update([
                    'status'=>$data['status']
                ]);  
            });
            
            $status=$user['status']==1 ? 'Enable' :'Disable';
            return response()->json([
                'response'=>true,
                'message'=>'User '. $status. ' Successfully',
                'own'=>auth()->id()==$user['id'] ?$user['id']:null,
            ]);
           
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
    }

}
