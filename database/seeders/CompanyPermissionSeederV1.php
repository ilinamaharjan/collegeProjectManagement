<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CompanyPermissionSeederV1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsId = [];
        $createdPermission = Permission::create([
            'name' => 'Admin|Dashboard',
            'guard_name' => 'web'
        ]);
        array_push($permissionsId, $createdPermission['id']);
        $moduleNames = ['Company'];
        $modules = Module::whereIn('name', $moduleNames)->with('subModules')->get();
        foreach ($modules as $module) {
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

            if (count($module['subModules']) > 0) {
                foreach ($module['subModules'] as $subModule) {
                    $permissionArr = [
                        [
                            'name' => 'View|' . $subModule['name'],
                            'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Create|' . $subModule['name'],
                            'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Update|' . $subModule['name'],
                            'guard_name' => 'web',
                        ],
                        [
                            'name' => 'Delete|' . $subModule['name'],
                            'guard_name' => 'web',
                        ],
                    ];
                    foreach ($permissionArr as $permission) {
                        $createdPermission = Permission::create($permission);
                        array_push($permissionsId, $createdPermission['id']);
                    }

                    if (count($subModule['subModules']) > 0) {
                        foreach ($subModule['subModules'] as $subSubModule) {
                            $permissionArr = [
                                [
                                    'name' => 'View|' . $subSubModule['name'],
                                    'guard_name' => 'web',
                                ],
                                [
                                    'name' => 'Create|' . $subSubModule['name'],
                                    'guard_name' => 'web',
                                ],
                                [
                                    'name' => 'Update|' . $subSubModule['name'],
                                    'guard_name' => 'web',
                                ],
                                [
                                    'name' => 'Delete|' . $subSubModule['name'],
                                    'guard_name' => 'web',
                                ],
                            ];
                            foreach ($permissionArr as $permission) {
                                $createdPermission = Permission::create($permission);
                                array_push($permissionsId, $createdPermission['id']);
                            }
                        }
                    }
                }
            }
        }


        $super_admin = Role::where('name', 'Super Admin')->first();
        $super_admin->givePermissionTo($permissionsId);
        $super_admin_user = User::where('name','Super Admin')->with('roles')->first();
        $super_admin_user->assignRole($super_admin);
    }
}
