<?php

use App\Models\User;
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
        $user_owner = User::create([
            'name' => 'Amar Ramadan',
            'email' => 'amarrmdn@hotmail.com',
            'password' => bcrypt('123123'),
            'job_title_id' => 1,
            'role_id' => 1,
        ]);

        $user_owner -> attachRole('owner');

        $user_owner = User::create([
            'name' => 'Developer',
            'email' => 'developer@skbmw-system.com',
            'password' => bcrypt('123123'),
            'role_id' => 1,
        ]);

        $user_owner -> attachRole('owner');


    }
}
