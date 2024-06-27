<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
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
            'name' => 'Admin|Dashbaord',
            'guard_name' => 'web'
        ]);
        array_push($permissionsId, $createdPermission['id']);

        $modules = Module::where('parent_module_id', null)->with('subModules')->get();
        foreach ($modules as $module) {
            $permissionArr = [
                [
                    'name' => 'View|' . $module['name'],
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'Create|' . $module['name'],
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'Update|' . $module['name'],
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'Delete|' . $module['name'],
                    'guard_name' => 'web',
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


        // assign permission to roles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin = Role::where('name', 'Admin')->first();
        $superAdmin->syncPermissions($permissionsId);
        $admin->syncPermissions($permissionsId);
    }
}
