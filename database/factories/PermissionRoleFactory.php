<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PermissionRole;
use Faker\Generator as Faker;
use App\Role;
use App\Permission;

$factory->define(PermissionRole::class, function (Faker $faker) {
    $permissions = Permission::pluck('id')->toArray();
    $roles = Role::pluck('id')->toArray();
    return [
        'permission_id' => $faker->randomElement($permissions),
        'role_id' => $faker->randomElement($roles),
        // Rest of attributes...
    ];
});
