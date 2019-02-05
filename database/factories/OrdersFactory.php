<?php

use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 15),
        'dish_id' => $faker->numberBetween(1, 15),
        'nb_servings' => $faker->numberBetween(0, 20),
        'price' => $faker->randomFloat(2, 1, 20),
        'sent' => $faker->boolean(),
        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});
