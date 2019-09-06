<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AttendanceMachine;
use Faker\Generator as Faker;

$factory->define(AttendanceMachine::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement(['machine 1', 'machine 2']),
    ];
});
