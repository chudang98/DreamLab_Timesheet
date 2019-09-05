<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    $startTime = '2019-08-01 00:00:00';
    $endingTime  = '2019-08-20 00:00:00';

    $fMin = strtotime($startTime);
    $fMax = strtotime($endingTime);
    $fVal = mt_rand($fMin, $fMax);

    return [
        //
        'date_time' => date('Y-m-d H:i:s', $fVal),
        'user_id' => $faker->randomElement(['1', '2', '3']),
        'attendance_machine_id' => $faker->randomElement(['1', '2']),
    ];
});

// function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s')
// {
//     // Convert the supplied date to timestamp
//     $fMin = strtotime($sStartDate);
//     $fMax = strtotime($sEndDate);
//     // Generate a random number from the start and end dates
//     $fVal = mt_rand($fMin, $fMax);
//     // Convert back to the specified date format
//     return date($sFormat, $fVal);
// }
