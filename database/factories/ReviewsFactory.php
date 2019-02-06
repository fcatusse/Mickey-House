<?php

use Faker\Generator as Faker;

$factory->define(App\Reviews::class, function (Faker $faker) {
    return [
        'order_id' => $faker->numberBetween(1, 5),
        'note' => $faker->numberBetween(0, 5),
        'comment' => $faker->text($maxNbChars = 200),
    ];
});
