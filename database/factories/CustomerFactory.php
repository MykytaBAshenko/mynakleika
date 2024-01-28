<?php

use App\Models\Customer;
use Faker\Generator;

$factory->define(Customer::class, function (Generator $faker) {

    return [
        'customer_name'    => $faker->name,
        'customer_city'    => $faker->city,
        'customer_address' => $faker->address,
        'manager_id'       => 1,
    ];
});
