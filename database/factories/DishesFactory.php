<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(\App\Dish::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'name' => $faker->name,
        'description' => $faker->text,
        'photos' => json_encode($faker->word.'.png'),
        'nb_servings' => $faker->numberBetween(10, 20),
        'price' => $faker->randomFloat(2, 1, 20),
        'categories' => json_encode([
            $faker->numberBetween(0, 15),
            $faker->numberBetween(0, 15),
            $faker->numberBetween(0, 15)
        ]),
        'is_visible' => $faker->boolean(),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) ,
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null)
    ];
});
