<?php

use App\Models\File;
use Faker\Generator;

$factory->define(File::class, function (Generator $faker) {

    return [
        'name' => 'file',
    ];
});
