<?php

use Faker\Generator as Faker;

$factory->define(App\Demand::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'email' => $faker->safeEmail,
        'budget' => $faker->randomFloat(2, 2, 150),
        'phone' => '0606060606',
        'user_id' => $faker->numberBetween(0, 10),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null)
    ];
});
