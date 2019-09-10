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
            ['id' => '1', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '1'],
            ['id' => '2', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '2'],
            ['id' => '3', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '3'],
            ['id' => '4', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '4'],
            ['id' => '5', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '5'],
            ['id' => '6', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '6'],
            ['id' => '7', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '7'],
            ['id' => '8', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '8'],
            ['id' => '9', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '9'],
            ['id' => '10', 'date' => '2019-09-05', 'morning_shift'=>'V', 'afternoon_shift'=>'V', 'user_id' => '10'],
        ]);
    }
}
