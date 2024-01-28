<?php

use App\Models\Order;
use Faker\Generator;

$factory->define(Order::class, function (Generator $faker) {

    return [
        'order_ref'         => 'Order',
        'production_status' => Order::HOLD,
        'finance_status'    => Order::NOT_PAID,
        'format'            => '23x54',
        'quantity'          => $faker->numberBetween(100, 2000),
        'quantity_per_sheet'=> $faker->numberBetween(10, 100),
        'chromaticity'      => 1,
        'lamination'        => 1,
        'delivery_cost'     => 0,
        'cost'              => $faker->randomFloat(2, 100, 10000),
        'order_creator_id'  => 1,
        'file_id'           => 1,
        'material_id'       => 1,
        'delivery_id'       => 1,
    ];
});
