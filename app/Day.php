<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Day extends Model
{
    public static function insertDay($date, $state, $startt_break, $endt_break, $reason){
        DB::table('days')->insert(
            [   'date' => $date,
                'state' =>$state,
                'startt_break' =>$startt_break,
                'endt_break' =>$endt_break,
                'reason' => $reason
            ]
        );
    }

    public static function updateDay($date, $state, $startt_break, $endt_break, $reason){
        DB::table('days')
            ->where('date', $date)
            ->update([
                'state' =>$state,
                'startt_break' =>$startt_break,
                'endt_break' =>$endt_break,
                'reason' => $reason
            ]);
    }
}
