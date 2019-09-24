<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Timesheet;
use Faker\Generator as Faker;
use App\User;

$factory->define(Timesheet::class, function (Faker $faker) {
    $users = User::pluck('id')->toArray();
    return [
        'date'=>$faker->dateTimeBetween('-20 days','now'),
        'morning_shift'=>$faker->randomElement(['V']),
        'afternoon_shift'=>$faker->randomElement(['V']),
        'user_id'=>$faker->unique()->randomElement($users),
        'check_in'=>$faker->time('h:i:s','10:00:00'),
        'check_out'=>$faker->time('h:i:s','20:00:00'),
    ];
});
