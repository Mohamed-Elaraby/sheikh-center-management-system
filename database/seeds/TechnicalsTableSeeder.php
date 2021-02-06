<?php

use App\Models\Technical;
use Illuminate\Database\Seeder;

class TechnicalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i =1; $i<6 ;$i++) {
            Technical::create([
                'name' => 'Technical_'.$i,
                'branch_id' => random_int(1,5),
            ]);
        }
    }
}
