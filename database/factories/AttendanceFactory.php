<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use Faker\Generator as Faker;
use App\AttendanceMachine;
use App\User;

$factory->define(Attendance::class, function (Faker $faker) {
    $attendance_machines = AttendanceMachine::pluck('id')->toArray();
    $users = User::pluck('id')->toArray();
    return [
        'date_time'=>$faker->dateTimeBetween('-20 days','now'),
        'attendance_machine_id'=>$faker->randomElement($attendance_machines),
        'user_id'=>$faker->randomElement($users),
        'is_check'=>$faker->randomElement(['N']),
    ];
});
