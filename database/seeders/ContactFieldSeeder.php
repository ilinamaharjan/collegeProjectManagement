<?php

namespace Database\Seeders;

use App\Models\CustomFieldType;
use Illuminate\Database\Seeder;

class ContactFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact_field = [
            'type' => 'Contacts'
        ];

        CustomFieldType::create($contact_field);
    }
}
