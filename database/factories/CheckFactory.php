<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Check;
use Faker\Generator as Faker;

$factory->define(Check::class, function (Faker $faker) {
    return [
        'check_number'              => $faker->randomNumber(6),
        'counter_number'            => $faker->randomNumber(6),
        'structure_number'          => $faker->randomNumber(6),
        'plate_number'              => $faker->randomNumber(6),
        'car_color'                 => $faker->colorName,
        'fuel_level'                => mt_rand(1,100),
        'car_status_report'         => $faker->text(1000),
        'check_status_id'           => mt_rand(1,6),
        'car_type_id'               => 1,
        'car_size_id'               => mt_rand(1,20),
        'car_model_id'              => mt_rand(1,20),
        'car_engine_id'             => mt_rand(1,20),
        'car_development_code_id'   => mt_rand(1,20),
        'client_id'                 => mt_rand(1,5),
        'user_id'                   => mt_rand(1,2),
        'branch_id'                 => mt_rand(1,5),
    ];
});
