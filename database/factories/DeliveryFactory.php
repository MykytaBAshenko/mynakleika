<?php

use App\Models\Delivery;
use Faker\Generator;

$factory->define(Delivery::class, function (Generator $faker) {

    return [
        'type'              => Delivery::TYPE_PICKUP,
        'city'              => $faker->city,
        'address'           => $faker->address,
        'contact_person'    => $faker->name,
        'contact_phone'     => '380994544333',
    ];
});
