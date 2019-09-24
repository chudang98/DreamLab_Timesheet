<?php

use Illuminate\Database\Seeder;

class TimesheetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory('App\Timesheet', 10)->create();
        DB::table('timesheets')->insert([
            ['id' => '1', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '1', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '2', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '2', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '3', 'date' => '2019-09-19', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '3', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '4', 'date' => '2019-09-15', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '4','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '5', 'date' => '2019-09-22', 'morning_shift'=>'B', 'afternoon_shift'=>'B', 'user_id' => '5','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '6', 'date' => '2019-09-15', 'morning_shift'=>'V', 'afternoon_shift'=>'X', 'user_id' => '6', 'check_in'=>'13:00:00', 'check_out'=>'19:00:00'],
            ['id' => '7', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'S', 'user_id' => '7', 'check_in'=>'8:00:00', 'check_out'=>'16:00:00'],
            ['id' => '8', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '8', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '9', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '9', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '10', 'date' => '2019-09-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '10', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '11', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '1', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '12', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '2', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '13', 'date' => '2019-08-19', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '3', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '14', 'date' => '2019-08-15', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '4','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '15', 'date' => '2019-08-22', 'morning_shift'=>'B', 'afternoon_shift'=>'B', 'user_id' => '5','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '16', 'date' => '2019-08-15', 'morning_shift'=>'V', 'afternoon_shift'=>'X', 'user_id' => '6', 'check_in'=>'13:00:00', 'check_out'=>'19:00:00'],
            ['id' => '17', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'S', 'user_id' => '7', 'check_in'=>'8:00:00', 'check_out'=>'16:00:00'],
            ['id' => '18', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '8', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '19', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '9', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '20', 'date' => '2019-08-15', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '10', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '21', 'date' => '2019-09-17', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '1', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '22', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '2', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '23', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '3', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '24', 'date' => '2019-09-01', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '4','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '25', 'date' => '2019-09-01', 'morning_shift'=>'B', 'afternoon_shift'=>'B', 'user_id' => '5','check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '26', 'date' => '2019-09-01', 'morning_shift'=>'V', 'afternoon_shift'=>'X', 'user_id' => '6', 'check_in'=>'13:00:00', 'check_out'=>'19:00:00'],
            ['id' => '27', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'S', 'user_id' => '7', 'check_in'=>'8:00:00', 'check_out'=>'16:00:00'],
            ['id' => '28', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '8', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '29', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '9', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
            ['id' => '30', 'date' => '2019-09-01', 'morning_shift'=>'X', 'afternoon_shift'=>'X', 'user_id' => '10', 'check_in'=>'8:00:00', 'check_out'=>'19:00:00'],
        ]);
    }
}
