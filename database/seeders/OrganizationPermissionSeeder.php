<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrganizationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsId = [];
        $moduleNames = ['Contact Organization'];
        $modules = Module::whereIn('name', $moduleNames)->with('subModules')->get();
        foreach ($modules as $module) {
            if($module['name']=="Contact Organization"){
                $permissionArr = [
                    [
                        'name' => 'View|' . $module['name'],
                        'guard_name' => 'web',
                        'module_id' => $module['id']
                    ],
                    [
                        'name' => 'Create|' . $module['name'],
                        'guard_name' => 'web',
                        'module_id' => $module['id']
                    ],
                    [
                        'name' => 'Update|' . $module['name'],
                        'guard_name' => 'web',
                        'module_id' => $module['id']

                    ],
                    [
                        'name' => 'Delete|' . $module['name'],
                        'guard_name' => 'web',
                        'module_id' => $module['id']

                    ],
                    [
                        'name' => 'ViewAll|' . $module['name'],
                        'guard_name' => 'web',
                        'module_id' => $module['id']

                    ],
                ];
            }




            foreach ($permissionArr as $permission) {
                $createdPermission = Permission::create($permission);
                array_push($permissionsId, $createdPermission['id']);
            }


        }


        // assign permission to roles
        $super_admin = Role::where('name', 'Super Admin')->first();
        $super_admin->givePermissionTo($permissionsId);
        $super_admin_user = User::where('name','Super Admin')->with('roles')->first();
        $super_admin_user->assignRole($super_admin);
    }
}
