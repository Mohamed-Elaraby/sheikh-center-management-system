<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_owner = \App\Models\User::create([
            'name' => 'owner',
            'email' => 'superAdmin@superAdmin.com',
            'password' => bcrypt('123123'),
            'job_title_id' => 1,
            'role_id' => 1,
        ]);

        $user_owner -> attachRole('owner');

        $user_general_manager = \App\Models\User::create([
            'name' => 'general_manager',
            'email' => 'general_manager@general_manager.com',
            'password' => bcrypt('123123'),
            'job_title_id' => 2,
            'role_id' => 2,
        ]);

        $user_general_manager -> attachRole('general_manager');

        $user_branch_manager = \App\Models\User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('123123'),
            'job_title_id' => 3,
            'role_id' => 3,
            'branch_id' => 2,
        ]);

        $user_branch_manager -> attachRole('branch_manager');

        $user_accountant = \App\Models\User::create([
            'name' => 'ahmed',
            'email' => 'ahmed@yahoo.com',
            'password' => bcrypt('123123'),
            'job_title_id' => 4,
            'role_id' => 4,
            'branch_id' => 2,
        ]);

        $user_accountant -> attachRole('accountant');

    }
}
