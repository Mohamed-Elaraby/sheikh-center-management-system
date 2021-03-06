<?php

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
        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CheckStatusTableSeeder::class);
//        $this->call(BranchesTableSeeder::class);
//        $this->call(TechnicalsTableSeeder::class);
//        $this->call(EngineersTableSeeder::class);
        $this->call(CarTypesTableSeeder::class);
        $this->call(CarSizesTableSeeder::class);
        $this->call(CarModelsTableSeeder::class);
        $this->call(CarEnginesTableSeeder::class);
        $this->call(CarDevelopmentCodeTableSeeder::class);
        $this->call(JobTitlesTableSeeder::class);
//        $this->call(ClientsTableSeeder::class);
//        $this->call(ChecksTableSeeder::class);
    }
}
