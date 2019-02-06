<?php

use Faker\Generator as Faker;
use App\User;
use App\Dish;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'dish_id' => factory(Dish::class)->create()->id,
        'nb_servings' => $faker->numberBetween(1, 3),
        'price' => $faker->randomFloat(1, 1, 5),
        'sent' => false,
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) ,
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) ,
        'charge_id' => null,
    ];
});
