<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class LeadModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                'name' => 'Lead',
                'display_name' => 'Lead',
                'status' => true,
            ],
        ];


        foreach ($modules as $module) {
            $data['parent_module_id'] = null;
            $data['name'] = $module['name'];
            $data['display_name'] = $module['display_name'];
            $data['status'] = $module['status'];
            $createdModule = Module::create($data);
            if (array_key_exists('sub_modules', $module) && count($module['sub_modules']) > 0) {
                foreach ($module['sub_modules'] as $subModule) {
                    $data['parent_module_id'] = $createdModule['id'];
                    $data['name'] = $subModule['name'];
                    $data['display_name'] = $subModule['display_name'];
                    $data['status'] = $subModule['status'];
                    $createdSubModule = Module::create($data);
                    if (array_key_exists('sub_modules', $subModule) && count($subModule['sub_modules']) > 0) {
                        foreach ($subModule['sub_modules'] as $subsubmodule) {
                            $data['parent_module_id'] = $createdSubModule['id'];
                            $data['name'] = $subsubmodule['name'];
                            $data['display_name'] = $subsubmodule['display_name'];
                            $data['status'] = $subsubmodule['status'];
                            $createdSubSubModule = Module::create($data);
                        }
                    }
                }
            }
        }
    }
}
