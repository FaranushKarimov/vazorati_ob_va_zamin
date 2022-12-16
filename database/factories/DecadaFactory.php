<?php

use Faker\Generator as Faker;

$factory->define(App\Decada::class, function (Faker $faker) {
    return [
        'wua_id' => $faker->randomDigit,
        'hydropost_id' => $faker->numberBetween(1,50),
        'description' => $faker->text,
        'type' => $faker->numberBetween($min = 1, $max = 2),
        'volume_1' => $faker->numberBetween($min = 0, $max = 9999),
        'volume_2' => $faker->numberBetween($min = 0, $max = 9999),
        'volume_3' => $faker->numberBetween($min = 0, $max = 9999),
		'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
