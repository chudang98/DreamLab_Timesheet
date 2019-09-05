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
        DB::table('users')->insert([
            ['id' => '1', 'attendance_number' => '123', 'name' => 'Duck', 'email' => 'duck@gmail.com', 'department' => 'DEV', 'password' => bcrypt('123'), 'attendance_machine_id' => '1'],
            ['id' => '2', 'attendance_number' => '124', 'name' => 'Thao', 'email' => 'thao@gmail.com', 'department' => 'DEV', 'password' => bcrypt('123'), 'attendance_machine_id' => '1'],
            ['id' => '3', 'attendance_number' => '125', 'name' => 'Minh', 'email' => 'minh@gmail.com', 'department' => 'BA',  'password' => bcrypt('123'), 'attendance_machine_id' => '2'],
        ]);
    }
}
