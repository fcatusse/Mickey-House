<?php

use Faker\Generator as Faker;
use App\Order;

$factory->define(App\Reviews::class, function (Faker $faker) {
    return [
        'order_id' => factory(Order::class)->create()->id,
        'note' => $faker->numberBetween(0, 5),
        'comment' => $faker->text($maxNbChars = 200),
    ];
});
