<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsId = [];
        $moduleNames = ['User Management'];
        $module = Module::whereIn('name', $moduleNames)->with('subModules')->first();
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
        ];

        foreach ($permissionArr as $permission) {
            $createdPermission = Permission::create($permission);
            array_push($permissionsId, $createdPermission['id']);
        }




        // assign permission to roles
        $super_admin = Role::where('name', 'Super Admin')->first();
        $super_admin->givePermissionTo($permissionsId);
        $super_admin_user = User::where('name','Super Admin')->with('roles')->first();
        $super_admin_user->assignRole($super_admin);
    }
}
