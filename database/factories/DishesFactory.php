<?php

use Faker\Generator as Faker;

$factory->define(\App\Dish::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 15),
        'name' => $faker->name,
        'description' => $faker->text,
        'photos' => $faker->word.'.png',
        'nb_servings' => $faker->numberBetween(0, 20),
        'price' => $faker->randomFloat(2, 1, 20),
        'categories' => serialize([
            $faker->numberBetween(0, 15),
            $faker->numberBetween(0, 15),
            $faker->numberBetween(0, 15)
        ]),
        'is_visible' => $faker->boolean(),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) ,
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) 
    ];
});
