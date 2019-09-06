<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\AttendanceMachine;

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

$factory->define(User::class, function (Faker $faker) {
    $attendance_machines = AttendanceMachine::pluck('id')->toArray();
    return [
        'attendance_number' => $faker->unique()->numberBetween($min= 1, $max =20),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'department'=>$faker->randomElement(['Technology','Human Resources','Accounting','Board of direction']),
        'password'=>bcrypt('password'),
        'email_verified_at' => now(),
        'attendance_machine_id'=>$faker->randomElement($attendance_machines),
        'remember_token' => Str::random(10),
    ];
});
