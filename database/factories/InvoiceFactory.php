<?php

use App\Models\Invoice;
use Faker\Generator;

$factory->define(Invoice::class, function (Generator $faker) {

    return [
        'status' => Invoice::STATUS_NOT_PAID,
    ];
});
