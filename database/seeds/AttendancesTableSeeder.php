<?php

use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory('App\Attendance', 200)->create();
        DB::table('attendances')->insert([
            ['date_time' => '2019-08-01 07:46:00', 'user_id' => '33','attendance_machine_id' => '1'],
            ['date_time' => '2019-08-01 17:46:00', 'user_id' => '33','attendance_machine_id' => '1'],
        ]);
    }
}
