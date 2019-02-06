<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt($faker->password(6)), // secret
        'firstname' => $faker->firstname,
        'lastname' => $faker->lastname,
        'address' => '12 rue Saint Nicolas',
        'postal_code' => 75012,
        'city'=> 'Paris',
        'lat' => 48.850798,
        'long' =>  2.374290,
        'is_admin' => 1,
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null) ,
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
    ];
});
