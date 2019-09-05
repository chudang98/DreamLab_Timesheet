<?php

use Illuminate\Database\Seeder;

class AttendanceMachinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('attendance_machines')->insert([
            ['id' => '1', 'name' => 'may1'],
            ['id' => '2', 'name' => 'may2'],
        ]);
    }
}
