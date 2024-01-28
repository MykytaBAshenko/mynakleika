<?php

use App\Models\Material;
use Faker\Generator;

$factory->define(Material::class, function (Generator $faker) {

    return [
        'material_name'  => 'Foil',
        'material_price' => 2870,
        'in_stock'       => true,
    ];
});
