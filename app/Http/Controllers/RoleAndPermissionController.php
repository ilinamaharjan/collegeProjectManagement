<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\CommonController;

class RoleAndPermissionController extends Controller
{
    public function getAllRoles(){
        try {
            if (Auth::user()->hasRole('Super Admin')) {
                $roles = Role::where('company_id', auth()->user()->company_id)->cursorPaginate(10);
            } else {
                $roles = Role::whereNotIn('name', ['Super Admin'])->where('company_id', auth()->user()->company_id)->cursorPaginate(10);
            }
            $users = User::where('company_id', auth()->user()->company_id)->get();
            // return view('backend.role.index', compact('roles', 'users'));
            return response()->json([
                'response'=>true,
                'roles'=>view('backend.role.components.roleTableList',compact('roles'))->render(),
                'users'=>view('backend.user_management.components.userTableList',compact('users'))->render(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
               'message'=>$th->getMessage()
            ]);
        }
           
        
    }
    public function create(){
        return view('backend.role.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string', 'unique:roles','regex:/^[a-zA-Z ]*$/'],
        ];
        $common_ctrl = new CommonController();
        $validation_response = $common_ctrl->validator($data, $rules);
        if ($validation_response['response'] == false) {
            Alert::error('Error Validation', $validation_response['error_message']);
            return back();
        }
        try {
            DB::transaction(function () use ($data) {
                $createdRole = Role::create([
                    'name' => $data['name'],
                    'guard_name' => 'web',
                    'company_id'=>auth()->user()->company_id
                ]);
                if (array_key_exists('permissions', $data) && count($data['permissions']) > 0) {
                    $createdRole->syncPermissions($data['permissions']);
                }
            });
            Alert::success('Success', 'Role Created');
            return redirect()->route('home.role');
        } catch (\Throwable $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }

   
    public function edit($id){
        $role=Role::findOrFail($id);
        return view('backend.role.edit',compact('role'));
    }
    public function update(Request $request, $id)
    {

        $data = $request->all();
        $rules = [
            'name' => ['required', 'string'],
        ];
        $common_ctrl = new CommonController();
        $validation_response = $common_ctrl->validator($data, $rules);
        if ($validation_response['response'] == false) {
            Alert::error('Error Validation', $validation_response['error_message']);
            return back();
        }
        try {
            DB::transaction(function () use ($data, $id) {
                $role = Role::where('id', $id)->where('company_id',auth()->user()->company_id)->first();
                DB::table('role_has_permissions')->where('role_id', $role->id)->delete();
                if(!in_array($role->name,['Admin'])){
                    $role->name = $data['name'];
                    $role->save();
                }
                if (array_key_exists('permissions', $data) && count($data['permissions']) > 0) {
                    $role->syncPermissions($data['permissions']);
                }
            });
            Alert::success('Success', 'Role Updated');
            return redirect()->route('home.role');
        } catch (\Throwable $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }
    public function userPermissionUpdate(Request $request, $id)
    {
        $data = $request->all();
        // $rules = [
        //     'name' => ['required', 'string'],
        // ];
        // $common_ctrl = new CommonController();
        // $validation_response = $common_ctrl->validator($data, $rules);
        // if ($validation_response['response'] == false) {
        //     Alert::error('Error Validation', $validation_response['error_message']);
        //     return back();
        // }
        try {
            DB::transaction(function () use ($data, $id) {
                $user=User::findOrFail($id);
                DB::table('model_has_permissions')->where('model_id', $user->id)->delete();
              
                if (array_key_exists('role_id', $data)) {
                    $newRole=Role::where('id',$data['role_id'])->first();
                    if($newRole){
                        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                        $user->assignRole($newRole);
                    }
                }
                if (array_key_exists('permissions', $data) && count($data['permissions']) > 0) {
                    $user->syncPermissions($data['permissions']);
                }
            });
            Alert::success('Success', 'User Updated Successfully');
            return redirect()->route('user_management.index');
        } catch (\Throwable $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }
    public function delete($id)
    {
         $role = Role::where('id', $id)->first();
        // if ($role) {
        //     $users = User::role($role->name)->get();
        //     if (count($users) > 0) {
        //         Alert::error('Cannot Delete', 'Role is assigned to some user.');
        //     } else {
        //         $role->delete();
        //         Alert::success('Success', 'Role Deleted');
        //     }
        // } else {
        //     Alert::error('Error', 'No such Role');
        // }
        // return back();
        try {
            if ($role) {
                $users = User::role($role->name)->get();
                if (count($users) > 0) {
                    return response()->json([
                        'response'=>false,
                        'message'=>'This role is assigned to some user.',
                    ]);
                } else {
                    $role->delete();
                    return response()->json([
                        'response'=>true,
                        'message'=>'Role Deleted SuccessFully',
                    ]);
                }
            } 
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
    }

    public function userPermissionEdit($id){
        $roles=Role::where('company_id',auth()->user()->company_id)->get();
        $user=User::where('id',$id)->with('permissions')->first();
        $userRoles=[];
        $previous_role=null;
        foreach ($user['roles'] as $key => $role) {
            $previous_role=Role::where('id',$role->id)->first();
            array_push($userRoles,$role->id);
        }
        $user_permission=[];
        foreach ($user['permissions'] as $key => $per) {
            array_push($user_permission,$per->id);
        }
        return view('backend.role.userPermissionEdit',compact('user','user_permission','roles','userRoles','previous_role'));
    }

    public function viewPermissionOfRole(Role $role){
        try {
            return response()->json([
               'page'=>view('backend.components.ViewRolePermissionList',compact('role'))->render(),
               'response'=>true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage(),
                'response'=>false,
             ]);
        }
    }
}
