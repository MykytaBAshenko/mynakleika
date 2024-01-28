<?php

use App\Models\Auth\User;
use App\Models\Manager;
use Faker\Generator;

$factory->define(Manager::class, function (Generator $faker) {
    $user = factory(User::class)->create();

    return [
        'user_id' => $user->id,
    ];
});
