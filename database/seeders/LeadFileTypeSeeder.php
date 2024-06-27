<?php

namespace Database\Seeders;

use App\Models\LeadFileType;
use Illuminate\Database\Seeder;

class LeadFileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_types = [
            [
                'name' => 'Contract',
                'has_multiple' => true,
            ],
            [
                'name' => 'Bill',
                'has_multiple' => false
            ]
        ];

        foreach ($file_types as $key => $file_type) {
            LeadFileType::create($file_type);
        }
    }
}
