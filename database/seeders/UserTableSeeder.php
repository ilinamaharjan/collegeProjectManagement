<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'username' => 'super-admin',
                'email' => 'super-admin@techart.com',
                'password' => bcrypt('asdfgh137'),
                'company_id' => 1,
            ]
        ];

        foreach ($users as $key => $user) {
            if ($user['email'] == 'super-admin@techart.com') {
                $user['email_verified_at'] = Carbon::now();
            }else {
                $user['email_verified_at'] = null;
            }
            $created_user = User::create($user);
        }
    }
}
