<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CompanyTableSeederV1::class]);
        $this->call([UserTableSeeder::class]);
        $this->call([CompanyModuleSeederV1::class]);
        $this->call([PackageModuleSeeder::class]);
        $this->call([RoleTableSeeder::class]);
        $this->call([CompanyPermissionSeederV1::class]);
        $this->call([PackagePermissionSeederV1::class]);
        $this->call([StatusSettingModuleSeeder::class]);
        $this->call([CustomFieldTypeSeeder::class]);
        $this->call([StatusSettingPermissionSeeder::class]);
        $this->call([ContactModuleSeeder::class]);
        $this->call([OrganizationModuleSeeder::class]);
        $this->call([ContactFieldSeeder::class]);
        $this->call([ContactPermissionSeeder::class]);
        $this->call([OrganizationPermissionSeeder::class]);
        $this->call([LeadFileTypeSeeder::class]);
        $this->call([LeadModuleSeeder::class]);
        $this->call([LeadModulePermissionSeeder::class]);
        $this->call([RoleModuleSeeder::class]);
        $this->call([RoleModulePermissionSeeder::class]);
        $this->call([UserManagementModuleSeeder::class]);
        $this->call([UserManagementModulePermissionSeeder::class]);
        $this->call([LeadSubModuleSeeder::class]);
        $this->call([LeadSubModulePermissionSeeder::class]);
        $this->call([LeadFileTypeSeeder::class]);
        $this->call([ActivityTypeSeeder::class]);
        $this->call([CustomerModuleSeeder::class]);
        $this->call([CustomerModulePermissionSeeder::class]);
        $this->call([ProjectManagerSeeder::class]);
        $this->call([ProjectManagerPermissionSeeder::class]);
        // $this->call([LeadFileTypeSettingModuleSeeder::class]);
        // $this->call([LeadFileTypeSettingPermissionModuleSeeder::class]);
    }
}
