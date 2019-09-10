<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory('App\User', 20)->create();
//        $user = App\User::all();
//        $user->roles()->attach(2);
//        $userAdmin = App\User::find(1);
//        $userAdmin->roles()->attach(1);

    }
}
