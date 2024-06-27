<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LeadSubModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsId = [];
        $moduleNames = ['Lead'];

        $module = Module::where('name', 'Lead')->with('subModules')->first();
                foreach ($module['subModules'] as $subModule) {
                    $permissionArr = [
                        [
                            'name' => 'View|' . $subModule['name'],
                            'guard_name' => 'web',
                            'module_id' => $subModule['id']
                        ],
                        [
                            'name' => 'Create|' . $subModule['name'],
                            'guard_name' => 'web',
                            'module_id' => $subModule['id']

                        ],
                        [
                            'name' => 'Update|' . $subModule['name'],
                            'guard_name' => 'web',
                            'module_id' => $subModule['id']

                        ],
                        [
                            'name' => 'Delete|' . $subModule['name'],
                            'guard_name' => 'web',
                            'module_id' => $subModule['id']

                        ],
                    ];
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
