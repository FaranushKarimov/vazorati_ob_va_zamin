<?php

use Faker\Generator as Faker;

$factory->define(App\Canal::class, function (Faker $faker) {
    return [
        'basin_id' => $faker->randomDigit,
        'wua_id' => $faker->randomDigit,
        'river_id' => $faker->randomDigit,
        'name_ru' => $faker->streetName,
        'name_tj' => $faker->streetName,
        'name_en' => $faker->streetName,
        'district' => $faker->word,
        'region' => $faker->word,
        'republic' => $faker->country,
        'source' => $faker->address,
        'year_of_commissioning' => $faker->numberBetween($min = 2010, $max = 2020),
        'material' => $faker->streetAddress,
        'bandwidth' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'top_width' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'bottom_width' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'depth' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'length' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'serviced_land' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'water_protection_strips' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0, $max = NULL),
        'number_of_water_outlets' => $faker->randomDigit,
        'technical_condition' => $faker->realText($maxNbChars = 100, $indexSize = 2),
        'notes' => $faker->realText($maxNbChars = 100, $indexSize = 2),
    ];
});
