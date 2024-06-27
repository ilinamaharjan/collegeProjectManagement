<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_data = [
            [
                'type_name' => 'General Activity'
            ],
            [
                'type_name' => 'Follow Up'
            ],
            [
                'type_name' => 'Client Visit'
            ]
        ];

        foreach ($arr_data as $key => $data) {
            ActivityType::create($data);
        }
    }
}
