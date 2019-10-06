<?php

use Illuminate\Database\Seeder;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('days')->insert([
            ['id'=>1,'date'=>'2019-09-26','state'=>'off','startt_break'=>null,'endt_break'=>null,'reason'=>'Nghỉ bù'],
            ['id'=>2,'date'=>'2019-09-28','state'=>'working','startt_break'=>null,'endt_break'=>null,'reason'=>'Làm bù'],
            ['id'=>3,'date'=>'2019-09-03','state'=>'off','startt_break'=>null,'endt_break'=>null,'reason'=>'Nghỉ bù'],
            ['id'=>4,'date'=>'2019-09-23','state'=>'break','startt_break'=>'08:30:00','endt_break'=>'14:00:00','reason'=>'Mất điện'],
            ['id'=>5,'date'=>'2019-09-02','state'=>'off','startt_break'=>null,'endt_break'=>null,'reason'=>'Nghỉ lễ'],
            ['id'=>6,'date'=>'2019-09-22','state'=>'working','startt_break'=>null,'endt_break'=>null,'reason'=>'Làm bù']
         ]);
    }
}
