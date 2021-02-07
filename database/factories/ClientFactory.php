<?php

/** @var Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker -> name,
        'phone' => $faker -> phoneNumber,
    ];
});
