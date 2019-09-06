<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PermissionUser;
use Faker\Generator as Faker;
use App\Permission;
use App\User;

$factory->define(PermissionUser::class, function (Faker $faker) {
    $permissions = Permission::pluck('id')->toArray();
    $users = User::pluck('id')->toArray();
    return [
        'permission_id' => $faker->randomElement($permissions),
        'role_id' => $faker->randomElement($users),
        // Rest of attributes...
    ];
});
