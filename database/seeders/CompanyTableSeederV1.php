<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeederV1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_company = [
            'name' => 'Techart',
            'email' => 'contact-support@techart.com',
            'website' => 'www.techart.com',
            'phone_number' => '01-4413142',
            'address' => 'Uttardhoka,Lazimpat',
            'total_employees' => 50
        ];

        Company::create($super_company);

    }
}
