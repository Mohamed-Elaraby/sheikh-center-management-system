<?php

use App\Models\ProductCode;
use Illuminate\Database\Seeder;

class ProductCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProductCode::class, 20)->create();
    }
}
