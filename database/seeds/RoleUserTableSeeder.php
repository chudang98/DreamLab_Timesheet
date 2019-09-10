<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=20; $i++){
            $user = App\User::find($i);
            if($i==1){
                $user->roles()->attach(1);
            }
            $user->roles()->attach(2);
        }

    }
}
