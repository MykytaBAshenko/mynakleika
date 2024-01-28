<?php

use App\Models\LegalEntity;
use Faker\Generator;

$factory->define(LegalEntity::class, function (Generator $faker) {

    return [
        'name'              => $faker->company,
        'alias'             => 'TOV1',
        'nds_payer'         => true,
        'nds_payer_num'     => '5436246',
        'ipn'               => '42343255344354',
        'bank_name'         => 'Universal',
        'edrpou'            => '4234325',
        'bank_account'      => $faker->iban('UA'),
        'director_fio'      => $faker->name,
        'f_index'           => $faker->postcode,
        'f_city'            => $faker->city,
        'f_street'          => $faker->streetName,
        'f_house'           => $faker->randomNumber(2),
        'f_office'          => $faker->randomNumber(2),
        'f_tel'             => $faker->phoneNumber,
        'l_index'           => $faker->postcode,
        'l_city'            => $faker->city,
        'l_street'          => $faker->streetName,
        'l_house'           => $faker->randomNumber(2),
        'l_office'          => $faker->randomNumber(2),
        'acc_email'         => $faker->companyEmail,
    ];
});
