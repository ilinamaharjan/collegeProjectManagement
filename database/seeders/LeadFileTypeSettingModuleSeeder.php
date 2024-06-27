<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class LeadFileTypeSettingModuleSeeder extends Seeder
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
                'name' => 'LeadFileType',
                'display_name' => 'LeadFileType',
                'status' => true,
            ],
        ];


        foreach ($modules as $module) {
            $data['parent_module_id'] = null;
            $data['name'] = $module['name'];
            $data['display_name'] = $module['display_name'];
            $data['status'] = $module['status'];
            $createdModule = Module::create($data);
        }
    }
}
