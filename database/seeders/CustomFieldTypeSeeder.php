<?php

namespace Database\Seeders;

use App\Models\CustomFieldType;
use Illuminate\Database\Seeder;

class CustomFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type' => 'Organization'
            ],
            [
                'type' => 'Leads'
            ],
            [
                'type' => 'Customer'
            ]
        ];

        foreach ($types as $key => $type) {
            CustomFieldType::create($type);
        }
    }
}
