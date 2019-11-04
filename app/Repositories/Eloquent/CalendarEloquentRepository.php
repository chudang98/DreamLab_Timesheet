<?php

namespace App\Repositories\Eloquent;

use App\Day;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Contracts\CalendarRepositoryInterface;
use DB;

class CalendarEloquentRepository extends EloquentRepository implements CalendarRepositoryInterface {

    public function getModel()
    {
        return Day::class;
    }

    public function findByDate($date){
        $result = $this->_model::where("date", $date)->first();
        return $result;
    }

    public function insertDay($d){
        DB::table('days')->insert(
            [   'date' => $d["date"],
                'state' =>$d["state"],
                'startt_break' =>$d["startt_break"],
                'endt_break' =>$d["endt_break"],
                'reason' => $d["reason"]
            ]
        );
    }

    public function updateDay($d){
        DB::table('days')->where('date', $d["date"])
            ->update([
                'state' =>$d["state"],
                'startt_break' =>$d["startt_break"],
                'endt_break' =>$d["endt_break"],
                'reason' => $d["reason"]
            ]);
    }
}
