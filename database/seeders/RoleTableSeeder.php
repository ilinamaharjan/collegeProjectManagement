<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'company_id' => 1
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'company_id' => 1
            ],
            [
                'name' => 'Staff',
                'guard_name' => 'web',
                'company_id' => 1
            ]
        ];


        foreach ($data as $datum) {
            Role::create($datum);
        }
    }
}
